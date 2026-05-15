<?php

namespace app\Controllers;

use app\Models\DataModel;
use app\Services\DataService;

class DataController
{
    public static function setData(): void
    {
        DataModel::setData(DataService::getArray());
    }
}
