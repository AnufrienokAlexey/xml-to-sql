<?php

namespace app\Controllers;

use app\Core\Db;
use app\Services\DataService;

class DataController
{
    public static function setData(): void
    {
        Db::setData(DataService::getArray());
    }
}
