<?php

namespace App\Common\Traits;

use Predis\Client as RedisClient;

trait CacheTrait
{
    protected RedisClient $redis;

    public function setRedisClient(RedisClient $redis): void
    {
        $this->redis = $redis;
    }

    private function getCacheKey(string $prefix): string
    {
        // return $prefix . '_' . (new \DateTime())->format('Y-m-d_H:i');
        return $prefix;
    }

    public function setCache(string $prefix, array $result, int $ttl = 300): void
    {
        $cacheKey = $this->getCacheKey($prefix);
        $this->redis->setex($cacheKey, $ttl, serialize($result));
    }

    public function getCache(string $prefix): ?array
    {
        $cacheKey = $this->getCacheKey($prefix);
        $data = $this->redis->get($cacheKey);
        return $data ? unserialize($data) : null;
    }

    public function clearCache(string $prefix): void
    {
        $cacheKey = $this->getCacheKey($prefix);
        $this->redis->del([$cacheKey]);
    }
}
