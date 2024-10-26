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

        $delivery_statuses = DeliveryStatus::all();

        return view('admin.shipments.index', compact('pageTitle', 'delivery_statuses'));
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
        $shipping_modes = ShippingMode::all();
        $service_modes = ServiceMode::all();
        $delivery_statuses = DeliveryStatus::all();
        $type_of_packagings = TypesOfPacking::all();
        $drivers = User::where('type', 2)->get();

        return view('admin.shipments.form', compact(
            'pageTitle',
            'delivery_times',
            'payment_methods',
            'shipping_modes',
            'service_modes',
            'delivery_statuses',
            'type_of_packagings',
            'drivers',
        ));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'shipment_number' => 'required',
            'sender_id' => 'required|exists:users,id',
            'recipient_id' => 'required|exists:users,id',
            'origin_address' => 'required|string|max:255',
            'destination_address' => 'required|string|max:255',
            'status_id' => 'required|exists:delivery_statuses,id',
            'delivery_time_id' => 'required|exists:delivery_times,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
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
            'shipment_number' => $validatedData['shipment_number'],
            'sender_id' => $validatedData['sender_id'],
            'recipient_id' => $validatedData['recipient_id'],
            'origin_address' => $validatedData['origin_address'],
            'destination_address' => $validatedData['destination_address'],
            'status_id' => $validatedData['status_id'],
            'payment_method_id' => $validatedData['payment_method_id'],
            'shipping_mode_id' => $validatedData['shipping_mode_id'],
            'service_mode_id' => $validatedData['service_mode_id'],
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

    public function edit($id): View
    {
        $pageTitle = 'Edit Shipment';
        $shipment = Shipment::with('items')->findOrFail($id); // Find the shipment by ID

        // Retrieve options for dropdowns as before
        $delivery_times = DeliveryTime::all();
        $payment_methods = PaymentMethod::all();
        $shipping_modes = ShippingMode::all();
        $service_modes = ServiceMode::all();
        $delivery_statuses = DeliveryStatus::all();
        $type_of_packagings = TypesOfPacking::all();
        $drivers = User::where('type', 2)->get();

        return view('admin.shipments.form', compact(
            'pageTitle',
            'shipment',
            'delivery_times',
            'payment_methods',
            'shipping_modes',
            'service_modes',
            'delivery_statuses',
            'type_of_packagings',
            'drivers',
        ));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
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

        // Step 2: Update shipment
        $shipment = Shipment::findOrFail($id);
        $shipment->update([
            'origin_address' => $validatedData['origin_address'],
            'destination_address' => $validatedData['destination_address'],
            'driver_id' => $validatedData['driver_id'],
            'shipment_date' => now(),
        ]);

        // Step 3: Update or create associated shipment items
        $shipment->shipmentItems()->delete(); // Clear old items
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

        return redirect()->route('shipments.index')->with('success', 'Shipment updated successfully.');
    }

    public function destroy($id): JsonResponse
    {
        $shipment = Shipment::findOrFail($id);

        // Delete related shipment items
        $shipment->items()->delete();

        // Delete the shipment
        $shipment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Shipment deleted successfully.'
        ]);
    }
}
