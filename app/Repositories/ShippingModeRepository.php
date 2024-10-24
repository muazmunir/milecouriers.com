<?php

namespace App\Repositories;

use App\Interfaces\ShippingModeInterface;
use App\Models\ShippingMode;
use Yajra\Datatables\Datatables;

class ShippingModeRepository implements ShippingModeInterface
{
    private $shipping_mode;

    private $datatables;

    public function __construct()
    {
        $this->shipping_mode = new ShippingMode;
        $this->datatables = new Datatables;
    }

    public function getDataTable()
    {
        $query = $this->shipping_mode->query();

        return $this->datatables->of($query)
            ->addColumn('action', function ($shippingMode) {
                $action = '<ul class="action">';

                // Edit Shipping Mode (opens modal)
                $action .= '<li class="edit"><a href="#" data-id="'.$shippingMode->id.'" id="editShippingMode"><i class="icon-pencil-alt"></i></a></li>';

                // Delete Shipping Mode (SweetAlert confirmation)
                $action .= '<li class="delete"><a href="#" data-id="'.$shippingMode->id.'" id="deleteShippingMode"><i class="icon-trash"></i></a></li>';

                $action .= '</ul>';

                return $action;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function createShippingMode(array $data)
    {
        return $this->shipping_mode->create($data);
    }

    public function findShippingModeById($id)
    {
        return $this->shipping_mode->find($id);
    }

    public function updateShippingMode($id, array $data)
    {
        $shippingMode = $this->shipping_mode->find($id);

        return $shippingMode ? $shippingMode->update($data) : null;
    }

    public function deleteShippingMode($id)
    {
        $shippingMode = $this->shipping_mode->find($id);

        return $shippingMode ? $shippingMode->delete() : false;
    }
}
