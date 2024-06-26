<?php
class RedisCache
{
  private $redis;

  public function __construct()
  {
    $this->redis = new Redis();
    $this->redis->connect("brocode-v4-redis", 6379);
  }

  // Function to set a key-value pair in Redis cache
  public function set($key, $value, $expiration = null)
  {
    if ($expiration) {
      $this->redis->setex($key, $expiration, $value);
    } else {
      $this->redis->set($key, $value);
    }
  }

  // Function to get a value from Redis cache using the key
  public function get($key)
  {
    return $this->redis->get($key);
  }

  // Function to check if a key exists in Redis cache
  public function exists($key)
  {
    return $this->redis->exists($key);
  }

  // Function to delete a key from Redis cache
  public function delete($key)
  {
    return $this->redis->del($key);
  }

  // Function to clear all keys from Redis cache
  public function flush()
  {
    return $this->redis->flushAll();
  }
}
