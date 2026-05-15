<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

use app\Core\Db;
use app\Core\Host;
use app\Core\Registry;
use PhpDevCommunity\DotEnv;

$microTime = microtime(true);

require_once __DIR__ . '/vendor/autoload.php';

(new DotEnv(__DIR__ . '/.env'))->load();

const APP = __DIR__ . '/app';
const DS = DIRECTORY_SEPARATOR;

dump(Host::getInstance());
dump(Db::getInstance());
dump(microtime(true) - $microTime);
