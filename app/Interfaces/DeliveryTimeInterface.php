<?php

namespace App\Interfaces;

interface DeliveryTimeInterface
{
    public function getDataTable();

    public function createDeliveryTime(array $data);

    public function findDeliveryTimeById(int $id);

    public function updateDeliveryTime(int $id, array $data);

    public function deleteDeliveryTime(int $id);
}
