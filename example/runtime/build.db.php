<?php return array (
  'mysql' => 
  array (
    'default' => 
    array (
      'host' => 'gz-cdb-k153onvv.sql.tencentcdb.com',
      'username' => 'api_user',
      'password' => 'nufang123!@#',
      'dbname' => 'fsxq_pub',
      'port' => 62401,
      'charset' => 'utf8mb4',
    ),
  ),
  'redis' => 
  array (
    'default' => 
    array (
      'host' => '192.168.0.13',
      'port' => 7833,
      'auth' => 'xiaoheiban123!@#',
    ),
  ),
  'mq' => 
  array (
    'default' => 
    array (
      'host' => '192.168.1.30',
      'port' => 5672,
      'login' => 'nufang',
      'password' => 'nufang123..',
      'vhost' => '/',
      'format' => 'igbinary',
    ),
  ),
  'log' => 
  array (
    'default' => 
    array (
      'app_key' => '132ceb11f8ab',
      'app_token' => '4a222981-6172-498c-aec1-06ff22d5c769',
    ),
  ),
);