<?php
/**
 * Created by IntelliJ IDEA.
 * User: lkzcm
 * Date: 2017/8/25
 * Time: 18:52
 */

class ayy
{
    /**
     * @var Application the application instance
     */
    public static $app;
    public static $classmap;

    public static function autoload($className)
    {
        if (ayy::$classmap[$className]) {
            include_once ayy::$classmap[$className];
        } else {
            if (strstr($className, "Redis")) {
                $class_array = explode("\\", $className);
                include_once project_dictory . "/redis/" . $class_array[2] . ".php";
            }
            if (strstr($className, "Controller")) {
                include_once project_dictory . "/action/" .$className. ".php";
            }
            if (strstr($className, "auto_cache")) {
                include_once project_dictory . "/redis/auto_cache/" . $className . ".php";
            }
        }
    }
}