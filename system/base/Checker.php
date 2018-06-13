<?php
/**
 * Created by IntelliJ IDEA.
 * User: lkzcm
 * Date: 2018/6/4
 * Time: 15:20
 */

namespace unit\base;

use unit;

class Checker
{
    public $field;

    public function check($array)
    {
        $param = require(project_dictory . '/common/param.php');
        foreach ($array as $value) {
            $field = $value;
            $comments = $value;
            if (!$param[$field]) {
                if (!isset($_REQUEST[$field])) {
                    unit::$output->error("请输入参数- $comments");
                } else {
                    $this->$field = $_REQUEST[$field];
                }
            }

            if (isset($param[$field]["comment"])) {
                $comments = $param[$field]["comment"];
            }
            if (isset($param[$field]["min_length"])) {
                if (strlen($_REQUEST[$field]) < $param[$field]["min_length"]) {
                    unit::$output->error($comments . "最小长度为" . $param[$field]["min_length"]);
                }
            }
            if (isset($param[$field]["max_length"])) {
                if (strlen($_REQUEST[$field]) > $param[$field]["max_length"]) {
                    unit::$output->error($comments . "最大长度为" . $param[$field]["max_length"]);
                }
            }
            if (isset($param[$field]["require"])) {
                if ($param[$field]["require"]) {
                    if (!$_REQUEST[$field]) {
                        unit::$output->error("请填写" . $comments . "有效值");
                    }
                }
            }

            if (isset($param[$field]["default_value"]) && !$_REQUEST[$field]) {
                $this->field[$field] = $param[$field]["default_value"];
            } else {
                if (isset($param[$field]["type"])) {
                    if ($param[$field]["type"] == "int") {
                        $_REQUEST[$field] = intval($_REQUEST[$field]);
                    }
                }
            }
            if ($param[$field]["checker"]) {
                $checker = $param[$field]["checker"];
                if($checker["class"]){
                    if(!class_exists($checker["class"])){
                        unit::$output->error($checker["class"]."未定义",1002);
                    }else{
                        $class = new \ReflectionClass($checker["class"]);
                    }
                   $ev=$class->getMethod($checker["method"]);
                    if(!$ev){
                        unit::$output->error($checker["method"]."方法未定义",1002);
                    }else{
                        $instance  = $class->newInstanceArgs();
                        if ($checker["param"]) {
                            $this->field[$field] = $ev->invoke( $instance,$_REQUEST[$field]);
                        } else {
                            $this->field[$field] ==$ev->invoke( $instance);
                        }
                    }
                }else {
                    $function=$checker["method"];
                    if (function_exists($function)) {
                        if ($checker["param"]) {
                            $this->field[$field] = call_user_func($function, $_REQUEST[$field]);
                        } else {
                            $this->field[$field] = call_user_func($function);
                        }
                    } else {
                        unit::$output->error($checker["method"] . "未定义", 1002);
                    }
                }
            }
            if (!$this->field[$field]) {
                $this->field[$field] = $_REQUEST[$field];
            }
        }

        return $this->field;
    }
}