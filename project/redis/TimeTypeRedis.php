<?php

namespace unit\redis;

use unit\model\TimeTypeModel;
use unit;

class TimeTypeRedis extends BaseRedis
{
    public function get_list()
    {
        $key = $this->prefix . "time_type";
        $data = $this->redis->hgetall($key);
        if (!$data) {
            $data = $this->set_list();
        }
        $result=array();
        foreach ($data as $value){
            $value=json_decode($value,true);
            array_push($result,$value);
        }
        return $result;
    }

    public function set_list()
    {
        $key = $this->prefix . "time_type";
        $data = (new TimeTypeModel())->get_all();
        $cache_data = [];
        if ($data) {
            foreach ($data as $value) {
                $cache_data[$value['id']] = json_encode($value);
            }
            $this->redis->hMSet($key, $cache_data);
        }
        return $cache_data;
    }
}

?>