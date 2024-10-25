<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ShipmentInterface;
use App\Models\DeliveryStatus;
use App\Models\DeliveryTime;
use App\Models\PaymentMethod;
use App\Models\ServiceMode;
use App\Models\ShippingMode;
use App\Models\TypesOfPacking;
use App\Models\User;
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
        $service_modes = ServiceMode::all();
        $delivery_statuses = DeliveryStatus::all();
        $type_of_packagings = TypesOfPacking::all();
        $drivers = User::where('type', 2)->get();

        return view('admin.shipments.form', compact(
            'pageTitle',
            'delivery_times',
            'payment_methods',
            'Shipping_modes',
            'service_modes',
            'delivery_statuses',
            'type_of_packagings',
            'drivers',
        ));
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
