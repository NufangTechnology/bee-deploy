<?php
require __DIR__ . '/../vendor/autoload.php';

$server = require 'db.php';

$pull = new \Bee\Deploy\Pull($server, __DIR__ . '/runtime');
$pull->run('pub');
