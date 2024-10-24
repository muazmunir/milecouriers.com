<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypesOfPackingRequest;
use App\Interfaces\TypesOfPackingInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class TypesOfPackingController extends Controller
{
    private $packingTypeRepository;

    public function __construct(TypesOfPackingInterface $packingTypeInterface)
    {
        $this->packingTypeRepository = $packingTypeInterface;
    }

    public function index(): View
    {
        $pageTitle = 'Types of Packing';

        return view('admin.types_of_packing.index', compact('pageTitle'));
    }

    public function dataTable(): JsonResponse
    {
        return $this->packingTypeRepository->getDataTable();
    }

    public function store(TypesOfPackingRequest $request): JsonResponse
    {
        $result = $this->packingTypeRepository->createPackingType($request->validated());

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Packing type added successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add packing type. Please try again.',
            ], 500);
        }
    }

    public function edit($id): JsonResponse
    {
        $packingType = $this->packingTypeRepository->findPackingTypeById($id);

        if ($packingType) {
            return response()->json([
                'success' => true,
                'data' => $packingType,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Packing type not found.',
        ], 404);
    }

    public function update(TypesOfPackingRequest $request, $id): JsonResponse
    {
        $result = $this->packingTypeRepository->updatePackingType($id, $request->validated());

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Packing type updated successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update packing type. Please try again.',
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->packingTypeRepository->deletePackingType($id);

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Packing type deleted successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete packing type. Please try again.',
            ], 500);
        }
    }
}
