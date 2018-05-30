<?php
return[
    #接口缓存
    'redisdb' => [
        "host" => "127.0.0.1", //必填,redis链接
        "port" => "6379", //必填（redis使用的端口，默认为6379）
        "password" => "***",  //必填 redis密码
        'db'=>"***",
        'class_name' => 'unit\extend\RedisCache'
    ],
    'db' => [
        // 'DB_HOST'=>'127.0.0.1',
        'DB_HOST' => '127.0.0.1',
        'DB_NAME' => '***',
        'DB_USER' => '***',
        'DB_PWD' => '***',
        'class_name' => 'unit\extend\PdoDb',
        "prefix"=>"***"
    ],
];

