<?php
return [
    'db' => [
        'name' => 'build.db.php',
        'mapping' => [
            'mysql.default' => 'w-dev-mysql-001',
            'redis.default' => 'w-dev-redis-001',
            'mq.default'    => 'w-dev-rabiitmq-001',
        ]
    ],

    'notify' => [
        'name' => 'build.verify.php',
        'mapping' => [
            'apple' => 'dev-apple-notify',
            'wx'    => 'dev-wx-charge-notify'
        ]
    ]
];
