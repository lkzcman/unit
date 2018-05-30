<?php
defined('AYY_PATH') or define('AYY_PATH', __DIR__);
require __DIR__.'/common.php';
require_once __DIR__ . '/Unit.php';
spl_autoload_register(["unit","autoload"],true,true);
unit::$classmap=require(__DIR__.'/classmap.php');
set_exception_handler(["unit\base\ErrorClass", 'error']);






