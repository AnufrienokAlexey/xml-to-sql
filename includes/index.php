<?php

require __DIR__ . '/../dev/debug.php';
require __DIR__ . '/../vendor/autoload.php';

$config = require 'config.php';
$host = $config['host'];
$database = $config['dbname'];
$charset = $config['charset'];
$username = $config['username'];
$password = $config['password'];

$connect = new Connect("$host", "$database", "$charset", "$username", "$password");
dd($connect->getAllTable());
dd($connect->createTable('personss'));
