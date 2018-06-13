<?php
namespace unit\action;

class baseController
{
    public function __construct()
    {

    }

    public function __destruct()
    {

    }

    public function check_config_key($key){
        if($key!="112233"){
            \unit::$output->error("config_key有误");
        }else{
            return $key;
        }
    }
}