<?php

namespace App\Interfaces;

interface ShippingModeInterface
{
    public function getDataTable();

    public function createShippingMode(array $data);

    public function findShippingModeById(int $id);

    public function updateShippingMode(int $id, array $data);

    public function deleteShippingMode(int $id);
}
