<?php

namespace App\Repositories;

use App\Interfaces\RoleInterface;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;
use Exception;

class RoleRepository implements RoleInterface
{
    private $role;
    private $user;
    private $datatables;

    public function __construct()
    {
        $this->role = new Role();
        $this->user = new User();
        $this->datatables = new Datatables();
    }

    public function getDataTable()
    {
        $query = $this->role->query();

        return $this->datatables->of($query)
            ->addColumn('action', function ($role) {

                if ($role->name === 'Super Admin') {
                    return '';
                }

                $action = '<ul class="action">';

                // Edit Role (opens modal)
                $action .= '<li class="edit"><a href="#" data-id="' . $role->id . '" id="editRole"><i class="icon-pencil-alt"></i></a></li>';

                // Assign Permissions to Role
                // $action .= '<li class="assign"><a href="' . route('roles.permissions', $role->id) . '"><i class="icon-key"></i></a></li>';

                // Delete Role (SweetAlert confirmation)
                $action .= '<li class="delete"><a href="#" data-id="' . $role->id . '" id="deleteRole"><i class="icon-trash"></i></a></li>';

                $action .= '</ul>';

                return $action;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function getRoles()
    {
        return $this->role->all();
    }

    public function getUserRoles($user_id)
    {
        $user = $this->user->with('roles')->findOrFail($user_id);
        return $user->roles;
    }

    public function createRole(array $data): bool
    {
        try {
            $this->role->create([
                'name' => $data['name'],
            ]);
            return true;
        } catch (Exception $e) {
            
            return false;
        }
    }

    public function findRoleById($id)
    {
        return $this->role->find($id);
    }

    public function updateRole($id, array $data): bool
    {
        try {
            $role = $this->role->findOrFail($id);
            $role->update(['name' => $data['name']]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteRole($id): bool
    {
        try {
            $role = $this->role->findOrFail($id);
            return $role->delete();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function assignPermissions($roleId, array $permissions): bool
    {
        try {
            $role = $this->role->findOrFail($roleId);
            $role->syncPermissions($permissions); // Syncs the given permissions
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
