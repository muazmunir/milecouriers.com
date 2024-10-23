<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ShipmentInterface;
use App\Models\DeliveryTime;
use App\Models\PaymentMethod;
use App\Models\ShippingMode;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    private $shipmentRepository;

    public function __construct(ShipmentInterface $shipmentInterface)
    {
        $this->shipmentRepository = $shipmentInterface;
    }

    public function index(): View
    {
        $pageTitle = 'Shipments';

        return view('admin.shipments.index', compact('pageTitle'));
    }

    public function create(): View
    {
        $pageTitle = 'Add Shipment';
        $delivery_times = DeliveryTime::all();
        $payment_methods = PaymentMethod::all();
        $Shipping_modes = ShippingMode::all();

        return view('admin.shipments.form', compact('pageTitle', 'delivery_times', 'payment_methods', 'Shipping_modes'));
    }
}
