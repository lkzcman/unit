<?php

namespace unit\redis;

use unit;

/**
 * Class BaseRedis
 * @property \unit\extend\RedisCache $redis The database connection.This property is read-only.
 */
class BaseRedis
{
    protected $prefix;
    protected $redis;

    public function __construct()
    {
        $this->redis = unit::$app->redis;
        $this->prefix = $this->redis->prefix;
    }

}

?>