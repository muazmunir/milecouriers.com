<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Interfaces\RoleInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    private $roleRepository;

    public function __construct(RoleInterface $userInterface)
    {
        $this->roleRepository = $userInterface;
    }

    public function index(): View
    {
        $pageTitle = 'Roles';

        return view('admin.roles.index', compact('pageTitle'));
    }

    public function dataTable(): JsonResponse
    {
        return $this->roleRepository->getDataTable();
    }

    public function store(RoleRequest $request): JsonResponse
    {
        $result = $this->roleRepository->createRole($request->validated());

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Role added successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add role. Please try again.',
            ], 500);
        }
    }

    public function edit($id): JsonResponse
    {
        $role = $this->roleRepository->findRoleById($id);

        if ($role) {
            return response()->json([
                'success' => true,
                'data' => $role,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Role not found.',
        ], 404);
    }

    public function update(RoleRequest $request, $id): JsonResponse
    {
        $result = $this->roleRepository->updateRole($id, $request->validated());

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update role. Please try again.',
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->roleRepository->deleteRole($id);

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete role. Please try again.',
            ], 500);
        }
    }
}
