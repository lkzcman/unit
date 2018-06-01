<?php
/**
 * Created by IntelliJ IDEA.
 * User: lkzcm
 * Date: 2017/8/25
 * Time: 19:12
 */

namespace unit\base;

use unit;

/**
 * Class Application
 * @property \unit\extend\PdoDb $db The database connection.This property is read-only.
 * @property \unit\extend\RedisCache $redis The database connection.This property is read-only.
 */
class Application
{
    protected $contain;

    public function __construct()
    {
        filter_request($_GET);
        filter_request($_POST);
        filter_request($_REQUEST);
        error_reporting(0);
        if ($_REQUEST["debug"]) {
            ini_set("display_errors", 1);
            error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
        }
        unit::$app = $this;
        unit::$output = new OutPut();
    }

    public function __get($name)
    {
        if ($this->contain[$name]) {
            return $this->contain[$name];
        } else {
            if (unit::$config[$name]) {
                $this->contain[$name] = new unit::$config[$name]["class_name"](unit::$config[$name]);
                return $this->contain[$name];
            } else {
                unit::$output->error($name . "不存在", 1003);
            }
        }

    }

    #加载模块和方法
    public function load_action()
    {
        $_REQUEST['ctl'] = filter_ma_request_mapi($_REQUEST['ctl']);
        $_REQUEST['act'] = filter_ma_request_mapi($_REQUEST['act']);
        $class = strtolower(strim_mapi($_REQUEST['ctl'])) ? strtolower(strim_mapi($_REQUEST['ctl'])) : "index";
        $act = strtolower(strim_mapi($_REQUEST['act'])) ? strtolower(strim_mapi($_REQUEST['act'])) : "index";
        $class = 'unit\action\\'.$class . 'Controller';
        if (class_exists($class)) {
            $obj = new $class;
            if (method_exists($obj, $act)) {
                $obj->$act();
            } else {
                unit::$output->error("接口方法不存在", 1002);
            }
        } else {
            unit::$output->error("控制器不存在", 1001);
        }
    }
}