<?php

namespace App\Interfaces;

interface PaymentMethodInterface
{
    public function getDataTable();

    public function createPaymentMethod(array $data);

    public function findPaymentMethodById($id);

    public function updatePaymentMethod($id, array $data);
    
    public function deletePaymentMethod($id);
}
