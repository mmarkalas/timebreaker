<?php

namespace App\Repositories\Eloquent;

use App\Models\TimeBreakdown;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\TimeBreakdownRepositoryInterface;
use App\Services\CachingServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TimeBreakdownRepository extends BaseRepository implements TimeBreakdownRepositoryInterface
{
    /**
     * TimeBreakdownRepository constructor.
     *
     * @param TimeBreakdown $model
     * @param CachingServiceInterface $cacheService
     */
    public function __construct(
        TimeBreakdown $model,
        CachingServiceInterface $cacheService
    ) {
        parent::__construct($model);
        $this->cacheService = $cacheService;
    }

    public function process(Request $request)
    {
        $this->parseExpressionAndSet($request->expression);
        $encodedRequest = $this->encodeRequest($request);

        $existing = $this->where('encoded_request', $encodedRequest)->first();
        
        if ($existing) {
            return $existing->result;
        }

        $result = $this->mapTimeBreakdown($request, $encodedRequest);

        return $result;
    }

    public function search(Request $request)
    {
        $cacheKey = $this->encodeRequest($request);

        if (!$this->cacheService->get($cacheKey)) {
            $fromDate = $request->has('from_date') ? Carbon::parse($request->from_date) : null;
            $toDate = $request->has('to_date') ? Carbon::parse($request->to_date) : null;
            
            if ($fromDate) {
                $this->where('from_date', $fromDate, '>=');
            }

            if ($toDate) {
                $this->where('to_date', $toDate, '<=');
            }

            $result = $this->get();

            $this->cacheService->put($cacheKey, $result);
        }

        $result = $this->cacheService->get($cacheKey);

        return $result;
    }

    private function parseExpressionAndSet($expression)
    {
        $parsed = $expression;

        if (!Arr::accessible($expression)) {
            if (!is_object($expression)) {
                $replaced = Str::of($expression)->replace(' ', '');
                $parsed = $replaced->explode(',')->toArray();
            }
        }

        $this->model->expression = $parsed;

        return;
    }

    private function encodeRequest(Request $request)
    {
        $payload = $request->all();

        if ($request->has('expression') && isset($this->model->expression)) {
            $payload['expression'] = json_encode($this->model->expression);
        }
        
        $encodedRequest = base64_encode(implode(",", $payload));

        return $encodedRequest;
    }

    private function mapTimeBreakdown(Request $request, string $encodedRequest)
    {
        $this->model->encoded_request = $encodedRequest;
        $this->model->from_date = Carbon::parse($request->from_date);
        $this->model->to_date = Carbon::parse($request->to_date);

        $timeDiff = (float) $this->model->from_date->diffInSeconds($this->model->to_date);

        $result = [];

        $sortedExpressions = $this->sortExpression($this->model->expression);

        foreach ($sortedExpressions as $key => $exp) {
            $count = getCountFromExpression($exp);
            $type = getLastCharacter($exp);

            $convertedToSec = $this->convertToSeconds($type, $count);
            
            $remainder = $timeDiff % $convertedToSec;

            if ($remainder != $timeDiff) {
                $total = floor($timeDiff / $convertedToSec);

                if ($key == (count($sortedExpressions) - 1)) {
                    $total = round($timeDiff / $convertedToSec, 2);
                }
                
                $timeDiff = $remainder;
            } else {
                $total = 0;
            }

            $result[$exp] = $total;
        }
        
        $this->model->result = $result;

        /**
            BUG: After saving the values to the database, the order of the "result" column json
            is being sorted by MySQL which is why it is changed after fetching values

            FROM:   {"6m": 0, "3m": 0, "2m": 0, "9d": 3, "6d": 1, "d": 2, "7h": 1, "8i": 41.25}
            TO:     {"d": 2, "2m": 0, "3m": 0, "6d": 1, "6m": 0, "7h": 1, "8i": 41.25, "9d": 3}

            RESOLUTION:
            Change "result" Column Data Type to text instead of json

         */
        $this->model->save();

        return $result;
    }

    private function sortExpression(array $expression)
    {
        rsort($expression, SORT_NUMERIC);

        $order = str_split("cDymwdhis");
        
        usort($expression, function ($a, $b) use ($order) {
            $substrA = getLastCharacter($a);
            $substrB = getLastCharacter($b);

            $posA = array_search($substrA, $order);
            $posB = array_search($substrB, $order);
          
            if ($substrA != $substrB) {
                return $posA - $posB;
            }

            $countA = getCountFromExpression($a);
            $countB = getCountFromExpression($b);

            return $countA > $countB ? -1 : 1;
        });
        
        $filteredExpression = array_values(array_unique($expression));
        
        return $filteredExpression;
    }
    
    private function convertToSeconds(string $type, float $count)
    {
        $secsPerMin = 60;
        $minsPerHour = 60;
        $hoursPerDay = 24;
        $daysPerWeek = 7;
        $daysPerMonth = 30; // We can assume that each month always has 30 days
        $monthsPerYear = 12;
        $yearPerDecade = 10;
        $decadePerCentury = 10;

        $mapToSeconds = [
            "c" => $secsPerMin * $minsPerHour * $hoursPerDay * $daysPerMonth *
                $monthsPerYear * $yearPerDecade * $decadePerCentury,
            "D" => $secsPerMin * $minsPerHour * $hoursPerDay * $daysPerMonth * $monthsPerYear * $yearPerDecade,
            "y" => $secsPerMin * $minsPerHour * $hoursPerDay * $daysPerMonth * $monthsPerYear,
            "m" => $secsPerMin * $minsPerHour * $hoursPerDay * $daysPerMonth,
            "w" => $secsPerMin * $minsPerHour * $hoursPerDay * $daysPerWeek,
            "d" => $secsPerMin * $minsPerHour * $hoursPerDay,
            "h" => $secsPerMin * $minsPerHour,
            "i" => $secsPerMin,
            "s" => 1,
        ];
        
        return (float) $count * $mapToSeconds[$type];
    }
}
