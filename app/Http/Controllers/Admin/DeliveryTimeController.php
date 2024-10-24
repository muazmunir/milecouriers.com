<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryTimeRequest;
use App\Interfaces\DeliveryTimeInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class DeliveryTimeController extends Controller
{
    private $deliveryTimeRepository;

    public function __construct(DeliveryTimeInterface $deliveryTimeInterface)
    {
        $this->deliveryTimeRepository = $deliveryTimeInterface;
    }

    public function index(): View
    {
        $pageTitle = 'Delivery Times';

        return view('admin.delivery_times.index', compact('pageTitle'));
    }

    public function dataTable(): JsonResponse
    {
        return $this->deliveryTimeRepository->getDataTable();
    }

    public function store(DeliveryTimeRequest $request): JsonResponse
    {
        $result = $this->deliveryTimeRepository->createDeliveryTime($request->validated());

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Delivery time added successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add delivery time. Please try again.',
            ], 500);
        }
    }

    public function edit($id): JsonResponse
    {
        $deliveryTime = $this->deliveryTimeRepository->findDeliveryTimeById($id);

        if ($deliveryTime) {
            return response()->json([
                'success' => true,
                'data' => $deliveryTime,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Delivery time not found.',
        ], 404);
    }

    public function update(DeliveryTimeRequest $request, $id): JsonResponse
    {
        $result = $this->deliveryTimeRepository->updateDeliveryTime($id, $request->validated());

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Delivery time updated successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update delivery time. Please try again.',
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->deliveryTimeRepository->deleteDeliveryTime($id);

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Delivery time deleted successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete delivery time. Please try again.',
            ], 500);
        }
    }
}
