<?php
$distribution_cfg = array(
    #接口缓存
    'redisdb' => [
        "host" => "127.0.0.1", //必填,redis链接
        "port" => "6379", //必填（redis使用的端口，默认为6379）
        "password" => "songxingwei1234",  //必填 redis密码
        'class_name' => 'Rediscache'
    ],
    'db' => [
        // 'DB_HOST'=>'127.0.0.1',
        'DB_HOST' => '127.0.0.1',
        'DB_NAME' => 'micro',
        'DB_USER' => 'root',
        'DB_PWD' => 'f7881f9ad6',
        'class_name' => 'mysqli_db',
        "prefix"=>"micro_"
    ],
    'db2' => [
        //'DB_HOST'=>'127.0.0.1',
        'DB_HOST' => '127.0.0.1',
        'DB_NAME' => 'timedeal',
        'DB_USER' => 'root',
        'DB_PWD' => 'f7881f9ad6',
        'class_name' => 'mysqli_db'
    ],
    'queue' => [
        "host" => "127.0.0.1", //必填,redis链接
        "port" => "6379", //必填（redis使用的端口，默认为6379）
        "password" => "songxingwei1234",  //必填 redis密码
        'class_name' => 'Rediscache'
    ],
    'session' => [
        'class_name' => 'es_session'
    ]);
    $distribution_cfg["REDIS_PREFIX"] = "yjy:";
define('DB_PREFIX', "micro.micro_");
define('DB_PREFIX2', "timedeal.m_");
return $distribution_cfg;

