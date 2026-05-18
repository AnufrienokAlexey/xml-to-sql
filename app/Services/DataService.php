<?php

namespace app\Services;

use app\Core\Convert;
use app\Models\DataModel;

class DataService
{
    public static function getArray() : array
    {
        $array = json_decode(Convert::getJson(), true); //RFC 7159 standart json
        if (json_last_error() !== JSON_ERROR_NONE) {
            die('При расшифровке JSON данных произошла ошибка: ' . json_last_error_msg());
        }
        return $array;
    }
}
