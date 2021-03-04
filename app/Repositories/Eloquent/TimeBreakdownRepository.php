<?php

namespace App\Repositories\Eloquent;

use App\Models\TimeBreakdown;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\TimeBreakdownRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class TimeBreakdownRepository extends BaseRepository implements TimeBreakdownRepositoryInterface 
{
    /**
     * IPAddressRepository constructor.
     *
     * @param IPAddress $model
     */
    public function __construct(TimeBreakdown $model)
    {
        parent::__construct($model);
    }

    public function process(Request $request)
    {
    	$fromDate = Carbon::parse($request->from_date);
    	$toDate = Carbon::parse($request->to_date);
    	$expressions = $this->parseExpression($request->expression);
    	$sortedExpressions = $this->sortExpression($expressions);

    	$timeDiff = (float) $fromDate->diffInSeconds($toDate);

    	$result = [];

    	foreach ($sortedExpressions as $key => $exp) {
    		$count = getCountFromExpression($exp);
    		$type = getLastCharacter($exp);

    		$convertedToSec = $this->convertToSeconds($type, $count);
    		
    		$remainder = $timeDiff % $convertedToSec;

    		if ($remainder != $timeDiff) {
    			$total = floor($timeDiff / $convertedToSec);

    			if ($key == (count($sortedExpressions) - 1)) {
    				$total = $timeDiff / $convertedToSec;
    			}
    			
    			$timeDiff = $remainder;
    		} else {
    			$total = 0;
    		}

    		$result[$exp] = $total;

    	}

    	return $result;
    }

    private function parseExpression($expression)
    {
    	$parsed = $expression;

    	if (!Arr::accessible($expression)) {
    		if (!is_object($expression)) {
    			$replaced = Str::of($expression)->replace(' ', '');
    			$parsed = $replaced->explode(',')->toArray();
    		}
    	}

    	return $parsed;
    }

    private function sortExpression(array $expression)
    {
    	rsort($expression, SORT_NUMERIC);

    	$order = str_split("mwdhis");
    	
		usort($expression, function ($a, $b) use ($order) {
			$substrA = getLastCharacter($a);
			$substrB = getLastCharacter($b);
		    $posA = array_search($substrA, $order);
		    $posB = array_search($substrB, $order);
		    return $posA - $posB;
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

    	$mapToSeconds = [
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
