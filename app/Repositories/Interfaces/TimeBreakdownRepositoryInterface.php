<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface TimeBreakdownRepositoryInterface extends BaseRepositoryInterface
{
    public function process(Request $request);

    public function search(Request $request);
}
