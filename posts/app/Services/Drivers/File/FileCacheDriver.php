<?php

namespace App\Services\Drivers\File;

use Illuminate\Support\Facades\File;

class FileCacheDriver implements \App\Services\CacheDriverInterface
{

    public function get(string $key)
    {
        $file = storage_path("framework/cache/{$key}");
        if (file_exists($file)) {
            $data = file_get_contents($file);
            $expiration = File::get($file . '.exp'); // فرض بر این است که تاریخ انقضا در یک فایل جداگانه ذخیره می‌شود
            if ($expiration && time() > (int)$expiration) {
                $this->forget($key); // کش منقضی شده است، حذف می‌شود
                return null;
            }
            return $data;
        }
        return null;
    }

    public function put(string $key, $value, int $ttl)
    {
        $file = storage_path("framework/cache/{$key}");
        file_put_contents($file, $value);
        // ذخیره تاریخ انقضا در یک فایل جداگانه
        file_put_contents($file . '.exp', time() + $ttl);
    }

    public function forget(string $key)
    {
        $file = storage_path("framework/cache/{$key}");
        if (file_exists($file)) {
            unlink($file);
        }
        $expFile = $file . '.exp';
        if (file_exists($expFile)) {
            unlink($expFile);
        }
    }
}
