<?php
/**
 * Created by IntelliJ IDEA.
 * User: lkzcm
 * Date: 2017/8/25
 * Time: 19:12
 */

/**
 * Class Application
 * @property mysqli_db $db The database connection.This property is read-only.
 * @property Rediscache $redisdb The database connection.This property is read-only.
 */
class Application{
    protected $contain;
    public $update_session=0;

    public function __construct()
    {
        filter_request($_GET);
        filter_request($_POST);
        filter_request($_REQUEST);
        error_reporting(0);
        if($_REQUEST["debug"]){
            ini_set("display_errors", 1);
            error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
        }
        ayy::$app=$this;
    }

    public function __get($name)
    {
        if(isset($_POST["debug"]))
            echo $name;
        if($this->contain[$name]){
            return $this->contain[$name];
        }else{
            if($GLOBALS["distribution_cfg"][$name]){
               $this->contain[$name]=new $GLOBALS["distribution_cfg"][$name]["class_name"]($GLOBALS["distribution_cfg"][$name]);
               return $this->contain[$name];
            }else{
                echo $name."不存在";
                die;
            }
        }

    }

    #加载模块和方法
    public function load_action(){
        $_REQUEST['ctl'] = filter_ma_request_mapi($_REQUEST['ctl']);
        $_REQUEST['act'] = filter_ma_request_mapi($_REQUEST['act']);
        $class = strtolower(strim_mapi($_REQUEST['ctl'])) ? strtolower(strim_mapi($_REQUEST['ctl'])) : "index";
        $act = strtolower(strim_mapi($_REQUEST['act'])) ? strtolower(strim_mapi($_REQUEST['act'])) : "index";
        $class = $class . 'Controller';
        if (class_exists($class)) {
            $obj = new $class;
            if (method_exists($obj, $act)) {
                $obj->$act();
            } else {
                $error["status"] = 10006;
                $error["error"] = "接口方法不存在";
                ajax_return($error);
            }
        } else {
            $error["status"] = 10005;
            $error["error"] = "接口不存在";
            ajax_return($error);
        }
    }
}