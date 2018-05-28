<?php
defined('AYY_PATH') or define('AYY_PATH', __DIR__);
require __DIR__.'/common.php';
require_once __DIR__.'/ayy.php';
spl_autoload_register(["ayy","autoload"],true,true);
ayy::$classmap=require(__DIR__.'/classmap.php');






