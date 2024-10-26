<?php

namespace App\Repositories;
use Yajra\Datatables\Datatables;

use App\Interfaces\ShipmentInterface;
use App\Models\Shipment;

class ShipmentRepository implements ShipmentInterface
{
    private $shipment;

    private $datatables;

    public function __construct()
    {
        $this->shipment = new Shipment();
        $this->datatables = new Datatables;
    }

    public function getDataTable()
    {
        $query = $this->shipment->with(['sender','recipient', 'status']);

        return $this->datatables->of($query)
            
            ->addColumn('sender', function ($shipment) {
                return $shipment->sender->full_name;
            })
            ->addColumn('recipient', function ($shipment) {
                return $shipment->recipient->full_name;
            })
            ->addColumn('status', function ($shipment) {
                return $shipment->status->name;
            })
            ->addColumn('action', function ($shipment) {
                $action = '<ul class="action">';

                // Edit Shipment (opens modal)
                $action .= '<li class="edit"><a href="'.route('shipments.edit', $shipment->id).'"><i class="icon-pencil-alt"></i></a></li>';

                // Delete Shipment (SweetAlert confirmation)
                $action .= '<li class="delete"><a href="#" data-id="'.$shipment->id.'" id="deleteShipment"><i class="icon-trash"></i></a></li>';

                $action .= '</ul>';

                return $action;
            })
            ->rawColumns(['sender', 'recipient', 'status', 'action'])
            ->toJson();
    }
}
