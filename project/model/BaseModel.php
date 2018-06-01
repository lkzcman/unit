<?php

namespace unit\model;

use unit;

/**
 * Class BaseRedis
 * @property \unit\extend\PdoDb $db The database connection.This property is read-only.
 */
class BaseModel
{
    protected $db;
    protected $prefix;

    public function __construct()
    {
        $this->db = unit::$app->db;
        $this->prefix = $this->db->prefix;
    }

}

?>