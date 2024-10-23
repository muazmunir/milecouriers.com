<?php

namespace App\Interfaces;

interface DeliveryStatusInterface
{
    public function getDataTable();

    public function createDeliveryStatus(array $data);

    public function findDeliveryStatusById(int $id);

    public function updateDeliveryStatus(int $id, array $data);

    public function deleteDeliveryStatus(int $id);
}
