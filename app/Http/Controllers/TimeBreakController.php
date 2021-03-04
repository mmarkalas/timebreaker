<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\TimeBreakdownRepositoryInterface;
use Illuminate\Http\Request;

class TimeBreakController extends Controller
{
    /**
     * @var TimeBreakdownRepositoryInterface
     */
    private $timeBreakdownRepository;

    /**
     * TimeBreakdownRepositoryInterface constructor.
     *
     * @param TimeBreakdownRepositoryInterface $timeBreakdownRepository
     */
    public function __construct(TimeBreakdownRepositoryInterface $timeBreakdownRepository)
    {
        parent::__construct();
        $this->timeBreakdownRepository = $timeBreakdownRepository;
    }

    public function index(Request $request)
    {
        return $this->runWithExceptionHandling(function () use ($request) {
            $this->response->setPayload([
                'data' => "TEST DATA"
            ]);
        });
    }

    public function breakTime(Request $request)
    {
        return $this->runWithExceptionHandling(function () use ($request) {
            $this->validate($request, [
                'from_date' => 'required|date|different:to_date',
                'to_date' => 'required|date|different:from_date',
                'expression' => 'required',
            ]);

            $result = $this->timeBreakdownRepository->process($request);
            // dd($result);
            $this->response->setPayload($result);
        });
    }
}
