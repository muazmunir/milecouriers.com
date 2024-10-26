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

    public function getDataTable($request)
    {
        $query = $this->shipment->with(['sender','recipient', 'status']);

        if ($request->has('shipment_number') && ! empty($request->get('shipment_number'))) {
            $query->where('shipment_number', 'like', '%'.$request->input('shipment_number').'%');
        }

        if ($request->has('start_date') && ! empty($request->get('start_date'))) {
            $query->whereDate('shipment_date', '>=', $request->get('start_date'));
        }

        // Apply the end date filter if it exists
        if ($request->has('end_date') && ! empty($request->get('end_date'))) {
            $query->whereDate('shipment_date', '<=', $request->get('end_date'));
        }

        if ($request->has('status_id') && ! empty($request->get('status_id'))) {
            $query->whereHas('status', function ($q) use ($request) {
                $q->where('id', $request->get('status_id'));
            });
        }

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
