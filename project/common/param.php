<?php
/**
 * Created by IntelliJ IDEA.
 * User: lkzcm
 * Date: 2018/1/30
 * Time: 14:56
 */
#参数字典
return [
    "mobile" => ['comment' => '手机号', 'checker' => [
        "method" => 'check_mobile'
        , 'param' => true,
        'class' => false], "require" => true, "type" => 'int'],
    "config_key" => ['comment' => '手机号', 'checker' => [
        "class" => "\unit\action\baseController",
        "method" => "check_config_key",
        "param" => true
    ], "require" => true, "type" => 'int', 'param' => "true"],
];