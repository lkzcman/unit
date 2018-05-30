<?php
define("project_dictory", __DIR__ . "/project");
include_once __DIR__ . '/system/init.php';
if(file_exists(project_dictory.'/common/common.php'))
    require_once project_dictory.'/common/common.php';
$application = new unit\base\Application();
unit::$config=require __DIR__ . '/public/config.php';

?>