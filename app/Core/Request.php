<?php

namespace app\Core;

class Request
{
    public static function getEntityBody()
    {
        $input = fopen('php://input', 'r');
        $contents = stream_get_contents($input);
        fclose($input);

        if (empty($contents)) {
            error_log('Incoming data is missing');
            die('Остутствуют входящие данные');
        }
        return $contents;
    }
}
