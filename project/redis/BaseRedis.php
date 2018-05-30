<?php
namespace ayy\redis;

/**
 * Class BaseRedis
 * @property \RedisCache $redis The database connection.This property is read-only.
 */
class BaseRedis
{

    var $redis;

    //  private $id;

    /**
     * +----------------------------------------------------------
     * 架构函数
     * +----------------------------------------------------------
     * @access public
     * +----------------------------------------------------------
     */
    public function __construct()
    {
        $this->redis = \unit::$app->redisdb;
        $this->prefix = $GLOBALS['distribution_cfg']['REDIS_PREFIX'];

    }

}
?>