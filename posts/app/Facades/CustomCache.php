<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @property string $driver
 * @method static mixed get(array|string $key, mixed|\Closure $default = null)
 * @method static bool put(array|string $key, mixed $value, \DateTimeInterface|\DateInterval|int|null $ttl = null)
 * @method static bool forget(string $key)
 */
class CustomCache extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'custom-cache';
    }
}
