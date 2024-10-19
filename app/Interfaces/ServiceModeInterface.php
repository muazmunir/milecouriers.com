<?php

namespace App\Interfaces;

interface ServiceModeInterface
{
    public function getDataTable();

    public function createServiceMode(array $data);

    public function findServiceModeById(int $id);

    public function updateServiceMode(int $id, array $data);

    public function deleteServiceMode(int $id);
}
