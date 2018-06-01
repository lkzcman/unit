<?php
/**
 * Created by IntelliJ IDEA.
 * User: lkzcm
 * Date: 2017/8/25
 * Time: 18:52
 */

class unit
{
    /**
     * @var unit\base\Application the application instance
     */
    public static $app;
    public static $classmap;
    public static $config;
    /**
     * @var unit\base\OutPut the application instance
     */
    public static $output;

    public static function autoload($className)
    {
        if (unit::$classmap[$className]) {
            include_once unit::$classmap[$className];
        } else {
            if (strstr($className, "Redis")) {
                $class_array = explode("\\", $className);
                include_once project_dictory . "/redis/" . $class_array[2] . ".php";
            }
            if (strstr($className, "model")) {
                $class_array = explode("\\", $className);
                include_once project_dictory . "/model/" . $class_array[2] . ".php";
            }
            if (strstr($className, "Controller")) {
                include_once project_dictory . "/action/" .$className. ".php";
            }
        }
    }
}