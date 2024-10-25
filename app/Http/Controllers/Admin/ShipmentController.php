<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ShipmentInterface;
use App\Models\DeliveryStatus;
use App\Models\DeliveryTime;
use App\Models\PaymentMethod;
use App\Models\ServiceMode;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\ShippingMode;
use App\Models\TypesOfPacking;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
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

    public function dataTable(): JsonResponse
    {
        return $this->shipmentRepository->getDataTable();
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
        $validatedData = $request->validate([
            'sender_id' => 'required|exists:users,id',
            'recipient_id' => 'required|exists:users,id',
            'origin_address' => 'required|string|max:255',
            'destination_address' => 'required|string|max:255',
            'delivery_time_id' => 'required|exists:delivery_times,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'delivery_status_id' => 'required|exists:delivery_statuses,id',
            'shipping_mode_id' => 'required|exists:shipping_modes,id',
            'service_mode_id' => 'required|exists:service_modes,id',
            'driver_id' => 'required|exists:users,id',
            'description.*' => 'required|string|max:255',
            'type_of_packaging.*' => 'required|exists:types_of_packings,id',
            'weight.*' => 'required|numeric|min:0',
            'length.*' => 'required|numeric|min:0',
            'width.*' => 'required|numeric|min:0',
            'height.*' => 'required|numeric|min:0',
            'declared_value.*' => 'required|numeric|min:0',
        ]);

        // Step 2: Create the shipment
        $shipment = Shipment::create([
            'sender_id' => $validatedData['sender_id'],
            'recipient_id' => $validatedData['recipient_id'],
            'origin_address' => $validatedData['origin_address'],
            'destination_address' => $validatedData['destination_address'],
            'driver_id' => $validatedData['driver_id'],
            'shipment_date' => now(),
        ]);

        // Step 3: Create associated shipment items
        foreach ($request->description as $index => $description) {
            ShipmentItem::create([
                'shipment_id' => $shipment->id,
                'description' => $description,
                'type_of_packaging_id' => $request->type_of_packaging[$index],
                'weight' => $request->weight[$index],
                'length' => $request->length[$index],
                'width' => $request->width[$index],
                'height' => $request->height[$index],
                'declared_value' => $request->declared_value[$index],
            ]);
        }

        // Step 4: Return a success response
        return redirect()->route('shipments.index')->with('success', 'Shipment created successfully.');
    }
}
