<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Interfaces\RoleInterface;
use App\Interfaces\UserInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    private $userRepository;

    private $roleRepository;

    public function __construct(UserInterface $userInterface, RoleInterface $roleInterface)
    {
        $this->userRepository = $userInterface;

        $this->roleRepository = $roleInterface;
    }

    public function index(): View
    {
        $pageTitle = 'Users';

        return view('admin.users.index', compact('pageTitle'));
    }

    public function dataTable(): JsonResponse
    {
        return $this->userRepository->getDataTable();
    }

    public function create(): View
    {
        $pageTitle = 'Add user';

        $roles = $this->roleRepository->getRoles();

        $user = null;

        return view('admin.users.form', compact('pageTitle', 'roles', 'user'));
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $this->userRepository->saveUser($request);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    public function edit($id): View
    {
        $pageTitle = 'Edit user';

        $user = $this->userRepository->getUser($id);

        $roles = $this->roleRepository->getRoles();

        $userRole = $this->roleRepository->getUserRoles($id);

        return view('admin.users.form', compact('pageTitle', 'user', 'roles', 'userRole'));
    }

    public function update(UserRequest $request, $id): RedirectResponse
    {
        $this->userRepository->updateUser($request, $id);
        
        return redirect()->back()->with([
            'message' => 'User Updated Successfully',
            'alert-type' => 'success',
        ]);
    }

    public function destroy($id): JsonResponse
    {
        try {
            // Call the repository method to delete the user
            $this->userRepository->deleteUser($id);

            // Return success response
            return response()->json([
                'message' => 'User deleted successfully',
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            // Return error response in case of exception
            return response()->json([
                'message' => 'Error deleting user',
                'status' => 'error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
