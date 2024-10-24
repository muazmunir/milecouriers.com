<?php

namespace App\Repositories;

use App\Interfaces\DeliveryStatusInterface;
use App\Models\DeliveryStatus;
use Yajra\Datatables\Datatables;

class DeliveryStatusRepository implements DeliveryStatusInterface
{
    private $delivery_status;

    private $datatables;

    public function __construct()
    {
        $this->delivery_status = new DeliveryStatus;
        $this->datatables = new Datatables;
    }

    public function getDataTable()
    {
        $query = $this->delivery_status->query();

        return $this->datatables->of($query)
            ->addColumn('action', function ($deliveryStatus) {
                $action = '<ul class="action">';

                // Edit Delivery Status (opens modal)
                $action .= '<li class="edit"><a href="#" data-id="'.$deliveryStatus->id.'" id="editDeliveryStatus"><i class="icon-pencil-alt"></i></a></li>';

                // Delete Delivery Status (SweetAlert confirmation)
                $action .= '<li class="delete"><a href="#" data-id="'.$deliveryStatus->id.'" id="deleteDeliveryStatus"><i class="icon-trash"></i></a></li>';

                $action .= '</ul>';

                return $action;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function createDeliveryStatus(array $data)
    {
        return $this->delivery_status->create($data);
    }

    public function findDeliveryStatusById($id)
    {
        return $this->delivery_status->find($id);
    }

    public function updateDeliveryStatus($id, array $data)
    {
        $deliveryStatus = $this->delivery_status->find($id);

        return $deliveryStatus ? $deliveryStatus->update($data) : null;
    }

    public function deleteDeliveryStatus($id)
    {
        $deliveryStatus = $this->delivery_status->find($id);

        return $deliveryStatus ? $deliveryStatus->delete() : false;
    }
}
