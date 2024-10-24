<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryStatusRequest;
use App\Interfaces\DeliveryStatusInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class DeliveryStatusController extends Controller
{
    private $deliveryStatusRepository;

    public function __construct(DeliveryStatusInterface $deliveryStatusInterface)
    {
        $this->deliveryStatusRepository = $deliveryStatusInterface;
    }

    public function index(): View
    {
        $pageTitle = 'Delivery Statuses';

        return view('admin.delivery_statuses.index', compact('pageTitle'));
    }

    public function dataTable(): JsonResponse
    {
        return $this->deliveryStatusRepository->getDataTable();
    }

    public function store(DeliveryStatusRequest $request): JsonResponse
    {
        $result = $this->deliveryStatusRepository->createDeliveryStatus($request->validated());

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Delivery status added successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add delivery status. Please try again.',
            ], 500);
        }
    }

    public function edit($id): JsonResponse
    {
        $deliveryStatus = $this->deliveryStatusRepository->findDeliveryStatusById($id);

        if ($deliveryStatus) {
            return response()->json([
                'success' => true,
                'data' => $deliveryStatus,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Delivery status not found.',
        ], 404);
    }

    public function update(DeliveryStatusRequest $request, $id): JsonResponse
    {
        $result = $this->deliveryStatusRepository->updateDeliveryStatus($id, $request->validated());

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Delivery status updated successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update delivery status. Please try again.',
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->deliveryStatusRepository->deleteDeliveryStatus($id);

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Delivery status deleted successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete delivery status. Please try again.',
            ], 500);
        }
    }
}
