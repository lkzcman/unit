<?php

namespace unit\model;

use unit;

class TimeTypeModel extends BaseModel
{
    public function get_all(){
        $sql="select * from time_type where status=1";
        $data=$this->db->getAll($sql);
        return $data;
    }
}

?>