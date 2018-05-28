<?php
define("project_dictory", __DIR__ . "/project");
include_once __DIR__ . '/system/mapi_init.php';
require_once __DIR__ . '/public/directory_init.php';
if(file_exists(project_dictory.'/common/common.php'))
    require_once project_dictory.'/common/common.php';
$application = new Application();
?>