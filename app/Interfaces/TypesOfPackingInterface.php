<?php

namespace App\Interfaces;

interface TypesOfPackingInterface
{
    public function getDataTable();

    public function createPackingType(array $data);

    public function findPackingTypeById(int $id);

    public function updatePackingType(int $id, array $data);

    public function deletePackingType(int $id);
}
