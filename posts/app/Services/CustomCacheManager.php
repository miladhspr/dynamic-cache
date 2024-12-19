<?php
namespace App\Services;

class CustomCacheManager
{
    protected CacheDriverInterface $cacheDriver;

    public function __construct(CacheDriverInterface $cacheDriver)
    {
        $this->cacheDriver = $cacheDriver;
    }

    public function get(string $key)
    {
        return $this->cacheDriver->get($key);
    }

    public function put(string $key, $value, int $ttl = 3600)
    {
        $this->cacheDriver->put($key, $value, $ttl);
    }

    public function forget(string $key)
    {
        $this->cacheDriver->forget($key);
    }
}
