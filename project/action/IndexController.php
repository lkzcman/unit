<?php
namespace unit\action;
use unit;

class IndexController extends baseController
{
    /*
     * ajax返回成功数据
     */
    public function ajax_success_return()
    {
        unit::$output->success("111");
    }

    /*
     * ajax返回错误数据
     */
    public function ajax_error_return()
    {
        unit::$output->error("111");
    }


    /*
     * 通过redis类获取数据
     */
    public function get_data_by_redis()
    {
        $data = (new unit\redis\TimeTypeRedis())->get_list();
        unit::$output->success($data);
    }

    /*
     * 通过db类获取数据
     */
    public function get_data_by_db()
    {
        $data = (new unit\model\TimeTypeModel())->getAll();
        unit::$output->success($data);
    }


    /*
     * db 查询参数预编译，防止sql注入
     */
    public function query_param(){
        $data=(new unit\model\TimeTypeModel())->get_time_type("吃饭");
        unit::$output->success($data);
    }

    /*
     * 使用参数检查器
     */
    public function check_param(){
        $field=unit::$checker->check(["config_key","mobile"]);
        unit::$output->success($field);
    }
}