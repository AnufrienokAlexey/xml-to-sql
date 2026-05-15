<?php

namespace app\Controllers;

use app\Core\Response;
use app\Services\FileService;

class File
{
    public function setData(): void
    {
        // Response::send(FileService::setData());
        echo 'filecontroller';
    }
}
