<?php

namespace App\Services\Drivers\Redis;

use Illuminate\Support\Facades\Redis;

class RedisCacheDriver implements \App\Services\CacheDriverInterface
{

    public function get(string $key)
    {
        if (Redis::ttl($key) < 0) {
            return null; // Cache expired
        }
        return Redis::get($key);
    }

    public function put(string $key, $value, int $ttl)
    {
        Redis::setex($key, $ttl, $value);
    }

    public function forget(string $key)
    {
        Redis::del($key);
    }
}
