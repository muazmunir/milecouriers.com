<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingModeRequest;
use App\Interfaces\ShippingModeInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class ShippingModeController extends Controller
{
    private $shippingModeRepository;

    public function __construct(ShippingModeInterface $shippingModeInterface)
    {
        $this->shippingModeRepository = $shippingModeInterface;
    }

    public function index(): View
    {
        $pageTitle = 'Shipping Modes';

        return view('admin.shipping_modes.index', compact('pageTitle'));
    }

    public function dataTable(): JsonResponse
    {
        return $this->shippingModeRepository->getDataTable();
    }

    public function store(ShippingModeRequest $request): JsonResponse
    {
        $result = $this->shippingModeRepository->createShippingMode($request->validated());

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Shipping mode added successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add shipping mode. Please try again.',
            ], 500);
        }
    }

    public function edit($id): JsonResponse
    {
        $shippingMode = $this->shippingModeRepository->findShippingModeById($id);

        if ($shippingMode) {
            return response()->json([
                'success' => true,
                'data' => $shippingMode,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Shipping mode not found.',
        ], 404);
    }

    public function update(ShippingModeRequest $request, $id): JsonResponse
    {
        $result = $this->shippingModeRepository->updateShippingMode($id, $request->validated());

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Shipping mode updated successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update shipping mode. Please try again.',
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->shippingModeRepository->deleteShippingMode($id);

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Shipping mode deleted successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete shipping mode. Please try again.',
            ], 500);
        }
    }
}
