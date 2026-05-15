<?php

namespace app\Core;

use app\Core\Request;

class Convert
{
    public static function getJson()
    {
        $contents = Request::getEntityBody();
        
        if (!simplexml_load_string($contents)) {
            error_log('The xml file cannot be recognized');
            die('Не удается распознать xml-файл');
        }

        $xml = simplexml_load_string($contents);
        return json_encode($xml);
    }
}
