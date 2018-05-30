<?php
/**
 * Created by IntelliJ IDEA.
 * User: lkzcm
 * Date: 2018/5/29
 * Time: 17:59
 */
namespace unit\base;

class OutPut{
    public function error($str,$status=0)
    {
        $data["status"] = $status;
        $data["error"] = $str;
        $this->ajax_return($data);
    }

    public function success($data)
    {
        $result["status"] = 1;
        $result["data"] =$data;
        $this->ajax_return($result);
    }

    /*ajax返回*/
    function ajax_return($data, $is_debug = false)
    {
        if (!$is_debug) {
            header("Content-Type:text/html; charset=utf-8");
            filter_null($data);//过滤null
            echo(json_encode($data));
            exit;
        } else {
            var_export($data);
            echo "<br />";
            exit;
        }
    }
}