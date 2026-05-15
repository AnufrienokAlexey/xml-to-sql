<?php

namespace app\Core;

class Convert
{
    public static function getData($xml)
    {
        $input = fopen('php://input', 'r');
        
        $contents = stream_get_contents($input);
        fclose($input);

        if (empty($contents)) {
            echo('Остутствуют входящие данные');
            die();
        }

        if (!simplexml_load_string($contents)) {
            echo ('Не усдается распознать xml-файл');
            die();
        } else {
            $xml = simplexml_load_string($contents);
            $json = json_encode($xml);
            echo($json);
        }
    }
}
