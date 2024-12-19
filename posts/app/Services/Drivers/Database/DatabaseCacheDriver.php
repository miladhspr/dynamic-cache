<?php

namespace App\Services\Drivers\Database;

use App\Services\CacheDriverInterface;
use Illuminate\Support\Facades\DB;

class DatabaseCacheDriver implements CacheDriverInterface
{

    public function get(string $key)
    {
        $cache = DB::table('cache')->where('key', $key)->first();
        if ($cache) {
            // بررسی اینکه آیا کش منقضی شده است یا خیر
            if ($cache->expiration < now()->timestamp) {
                $this->forget($key); // کش منقضی شده است، حذف می‌شود
                return null;
            }
            return $cache->value;
        }
        return null;
    }

    public function put(string $key, $value, int $ttl)
    {
        DB::table('cache')->updateOrInsert(
            ['key' => $key],
            ['value' => $value, 'expiration' => now()->addSeconds($ttl)->timestamp]
        );
    }

    public function forget(string $key)
    {
        DB::table('cache')->where('key', $key)->delete();
    }
}
