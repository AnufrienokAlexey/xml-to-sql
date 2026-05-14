<?php

namespace app\Controllers;

use app\Core\Response;
use app\Services\FileService;

class File
{
    public function list(): void
    {
        Response::send(FileService::list());
    }

    public function getId($id = null): void
    {
        Response::send(FileService::getInfoFile($id), $id);
    }

    public function add(): void
    {
        if (isset($_FILES['file'])) {
            FileService::add($_FILES['file']);
        }
    }

    public function rename(): void
    {
        Response::send(FileService::renameFile());
    }

    public function removeId($id = null): void
    {
        Response::send(FileService::deleteRow($id), $id);
    }

    public function shareId($id = null): void
    {
        Response::send(FileService::shareId($id), $id);
    }

    public function shareIdUserId($id = null, $userId = null): void
    {
        Response::send(FileService::shareIdUserId($id, $userId), $id, $userId);
    }

    public function deleteIdUserId($id = null, $userId = null): void
    {
        Response::send(FileService::deleteIdUserId($id, $userId), $id, $userId);
    }

}