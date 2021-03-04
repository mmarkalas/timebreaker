<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\TimeBreakdownRepositoryInterface;

class TimeBreakController extends Controller
{
    /**
     * @var TimeBreakdownRepositoryInterface
     */
    private $timeBreakdownRepository;

   /**
     * IPAddressRepository constructor.
     *
     * @param TimeBreakdownRepositoryInterface $timeBreakdownRepository
     */
    public function __construct(
        TimeBreakdownRepositoryInterface $timeBreakdownRepository
    ) {
        $this->timeBreakdownRepository = $timeBreakdownRepository;
    }

    public function index()
    {
        return "index";
    }

    public function breakTime()
    {
        return "breakTime";
    }
}
