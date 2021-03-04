<?php

namespace App\Repositories\Eloquent;

use App\Models\TimeBreakdown;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\TimeBreakdownRepositoryInterface;

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
}
