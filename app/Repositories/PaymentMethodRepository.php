<?php

namespace App\Repositories;

use App\Interfaces\PaymentMethodInterface;
use App\Models\PaymentMethod;
use Yajra\Datatables\Datatables;

class PaymentMethodRepository implements PaymentMethodInterface
{
    private $payment_method;
    private $datatables;

    public function __construct()
    {
        $this->payment_method = new PaymentMethod();
        $this->datatables = new Datatables();
    }

    public function getDataTable()
    {
        $query = $this->payment_method->query();

        return $this->datatables->of($query)
            ->addColumn('action', function ($paymentMethod) {
                $action = '<ul class="action">';

                // Edit Payment Method (opens modal)
                $action .= '<li class="edit"><a href="#" data-id="' . $paymentMethod->id . '" id="editPaymentMethod"><i class="icon-pencil-alt"></i></a></li>';

                // Delete Payment Method (SweetAlert confirmation)
                $action .= '<li class="delete"><a href="#" data-id="' . $paymentMethod->id . '" id="deletePaymentMethod"><i class="icon-trash"></i></a></li>';

                $action .= '</ul>';

                return $action;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function createPaymentMethod(array $data)
    {
        return $this->payment_method->create($data);
    }

    public function findPaymentMethodById($id)
    {
        return $this->payment_method->find($id);
    }

    public function updatePaymentMethod($id, array $data)
    {
        $paymentMethod = $this->payment_method->find($id);
        return $paymentMethod ? $paymentMethod->update($data) : null;
    }   

    public function deletePaymentMethod($id)
    {
        $paymentMethod = $this->payment_method->find($id);
        return $paymentMethod ? $paymentMethod->delete() : false;
    }
}
