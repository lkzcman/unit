<?php

namespace unit\model;

use unit;

class TimeTypeModel extends BaseModel
{
    public function getAll(){
        $sql="select * from time_type where status=1";
        $data=$this->db->getAll($sql);
        return $data;
    }

    public function get_time_type($name){
        $sql="select * from time_type where name=:name limit 1";
        $param[":name"] = $name;
        $data=$this->db->getRow($sql,$param);
        return $data;
    }
}
?>