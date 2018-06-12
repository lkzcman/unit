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
            if ($param[$field]["function"]) {
                $function = $param[$field]["function"];
                if (function_exists($function)) {
                    if ($param[$field]["param"]) {
                        $this->field[$field] = $function($_REQUEST[$field]);
                    } else {
                        $this->field[$field] = $function();
                    }
                } else {
                    if ($param[$field]["param"]) {
                        $this->field[$field] = $this->$function($_REQUEST[$field]);
                    } else {
                        $this->field[$field] = $this->$function();
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