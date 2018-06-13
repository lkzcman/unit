<?php

function api_log()
{

    $log = "request：" . "\t" . json_encode($_REQUEST) . "\t" . "session：" . "\t" . json_encode($_SESSION) . "\t" .
        "cookie:\t" . json_encode($_COOKIE) . "\t" . "file:\t" . json_encode($_FILES) . "\tserver:\t" . json_encode($_SERVER) . "\n";
    $file2 = "/alidata/log/qs/api/" . date("Ymd", time()) . "_" . $_REQUEST['ctl'] . "_" . $_REQUEST["act"] . "_api.log";
    file_put_contents($file2, $log, FILE_APPEND);
}

function check_mobile($mobile)
{
    if (!empty($mobile) && !preg_match("/^(1[0-9]{10})?$/", $mobile)) {
        unit::$output->error("请填写正确手机号");
    } else
        return $mobile;
}
