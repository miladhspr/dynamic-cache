<?php

namespace App\Services;

interface CacheDriverInterface
{
    public function get(string $key);
    public function put(string $key, $value, int $ttl);
    public function forget(string $key);
}
