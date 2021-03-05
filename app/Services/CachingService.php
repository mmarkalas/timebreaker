<?php

namespace App\Services;

use App\Services\CachingServiceInterface;
use Illuminate\Support\Facades\Cache;

class CachingService implements CachingServiceInterface
{
    protected $cache;

    public function __construct()
    {
        $cacheDriver = config('cache.default');
        $this->cache = Cache::store($cacheDriver);
    }

    /**
     * Get Cache data by key
     * @param  string $key
     * @return mixed  $data
     */
    public function get(string $key)
    {
        $data = null;

        if ($this->cache->has($key)) {
            $data = $this->cache->get($key);
        }

        return $data;
    }

    /**
     * Store Data to Cache
     * @param  string       $key
     * @param  mixed        $data
     * @param  int|integer  $seconds
     * @return bool
     */
    public function put(string $key, $data, int $seconds = 10): bool
    {
        return $this->cache->put($key, $data, $seconds);
    }

    /**
     * Remove Data in Cache by using the key
     * @param  string  $key
     * @return bool
     */
    public function forget(string $key): bool
    {
        return $this->cache->forget($key);
    }
}
