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
        $query = $this->shipment->query();

        return $this->datatables->of($query)
            ->toJson();
    }
}
