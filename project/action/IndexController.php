<?php
namespace unit\action;
use unit;

class IndexController extends baseController
{
    public function ajax_success_return()
    {
        unit::$output->success("111");
    }

    public function ajax_error_return()
    {
        unit::$output->error("111");
    }


    public function get_redis()
    {
        var_dump(unit::$app->redis);
    }


    public function get_db()
    {
        var_dump(unit::$app->db);
    }


    public function get_data_by_redis()
    {
        $data = (new unit\redis\TimeTypeRedis())->get_list();
        unit::$output->success($data);
    }

    public function get_data_by_db()
    {
        $data = (new \unit\model\TimeTypeModel())->get_all();
        unit::$output->success($data);
    }
}