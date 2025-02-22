<?php

namespace App\Http\Controllers;

use App\Models\Shipment;

class HomeController extends Controller
{
    public function index()
    {
        $pageTitle = 'Home';

        return view('frontend.index', compact('pageTitle'));
    }

    public function showTracking($shipment_number)
    {
        $shipment = Shipment::with(['tracking'])->where('shipment_number', $shipment_number)->first();

        // Format the tracking history dynamically
        $trackHistory = $shipment->tracking->map(function ($tracking) use ($shipment) {
            return [
                'date' => $tracking->tracked_at,
                'time' => $tracking->tracked_at,
                'status' => $shipment->status->name, // Make sure status is properly formatted or use a label accessor
                'location' => $tracking->location,
            ];
        });

        // Get the latest status from status histories or the main shipment status       
        return response()->json([
            'trackingNumber' => $shipment->shipment_number,
            'origin' => $shipment->origin_address,
            'destination' => $shipment->destination_address,
            'bookingDate' => $shipment->shipment_date,
            'currentStatus' => $shipment->status->name,
            'deliveredOn' => $shipment->actual_delivery_date,
            'receivedBy' => $shipment->received_by, // Assuming `recipient` relation with user name
            'trackHistory' => $trackHistory,
        ]);
        }
    }
