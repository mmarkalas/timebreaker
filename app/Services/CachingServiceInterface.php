<?php

namespace App\Services;

interface CachingServiceInterface
{
    /**
     * Get Cache data by key
     * @param  string $key
     * @return mixed $data
     */
    public function get(string $key);

    /**
     * Store Data to Cache
     * @param  string      $key
     * @param  mixed      $data
     * @param  int|integer $seconds
     * @return bool
     */
    public function put(string $key, $data, int $seconds = 10);

    /**
     * Remove Data in Cache by using the key
     * @param  string $key [description]
     * @return bool
     */
    public function forget(string $key);
}
