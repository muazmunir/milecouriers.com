<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceModeRequest;
use App\Interfaces\ServiceModeInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class ServiceModeController extends Controller
{
    private $serviceModeRepository;

    public function __construct(ServiceModeInterface $serviceModeInterface)
    {
        $this->serviceModeRepository = $serviceModeInterface;
    }

    public function index(): View
    {
        $pageTitle = 'Service Modes';

        return view('admin.service_modes.index', compact('pageTitle'));
    }

    public function dataTable(): JsonResponse
    {
        return $this->serviceModeRepository->getDataTable();
    }

    public function store(ServiceModeRequest $request): JsonResponse
    {
        $result = $this->serviceModeRepository->createServiceMode($request->validated());

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Service mode added successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add service mode. Please try again.',
            ], 500);
        }
    }

    public function edit($id): JsonResponse
    {
        $serviceMode = $this->serviceModeRepository->findServiceModeById($id);

        if ($serviceMode) {
            return response()->json([
                'success' => true,
                'data' => $serviceMode,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Service mode not found.',
        ], 404);
    }

    public function update(ServiceModeRequest $request, $id): JsonResponse
    {
        $result = $this->serviceModeRepository->updateServiceMode($id, $request->validated());

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Service mode updated successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update service mode. Please try again.',
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->serviceModeRepository->deleteServiceMode($id);

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Service mode deleted successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete service mode. Please try again.',
            ], 500);
        }
    }
}
