<?php
/**
 * Created by IntelliJ IDEA.
 * User: lkzcm
 * Date: 2018/5/30
 * Time: 11:53
 */

namespace Unit\base;

use unit;

class ErrorClass
{

    public static function error($e)
    {

        if ($_REQUEST["debug"]) {
            unit::$output->error($data["message"] = $e->getMessage(), 1004);
        } else {
            unit::$output->error("系统异常", 1004);
        }
    }
}