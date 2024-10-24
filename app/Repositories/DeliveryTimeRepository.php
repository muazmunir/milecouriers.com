<?php

namespace App\Repositories;

use App\Interfaces\DeliveryTimeInterface;
use App\Models\DeliveryTime;
use Yajra\Datatables\Datatables;

class DeliveryTimeRepository implements DeliveryTimeInterface
{
    private $delivery_time;

    private $datatables;

    public function __construct()
    {
        $this->delivery_time = new DeliveryTime;
        $this->datatables = new Datatables;
    }

    public function getDataTable()
    {
        $query = $this->delivery_time->query();

        return DataTables::of($query)
            ->addColumn('action', function ($deliveryTime) {
                $action = '<ul class="action">';

                // Edit Delivery Time (opens modal)
                $action .= '<li class="edit"><a href="#" data-id="'.$deliveryTime->id.'" id="editDeliveryTime"><i class="icon-pencil-alt"></i></a></li>';

                // Delete Delivery Time (SweetAlert confirmation)
                $action .= '<li class="delete"><a href="#" data-id="'.$deliveryTime->id.'" id="deleteDeliveryTime"><i class="icon-trash"></i></a></li>';

                $action .= '</ul>';

                return $action;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function createDeliveryTime(array $data)
    {
        return $this->delivery_time->create($data);
    }

    public function findDeliveryTimeById(int $id)
    {
        return $this->delivery_time->find($id);
    }

    public function updateDeliveryTime(int $id, array $data)
    {
        $deliveryTime = $this->delivery_time->find($id);

        return $deliveryTime ? $deliveryTime->update($data) : null;
    }

    public function deleteDeliveryTime(int $id)
    {
        $deliveryTime = $this->delivery_time->find($id);

        return $deliveryTime ? $deliveryTime->delete() : false;
    }
}
