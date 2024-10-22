<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;

class UserRepository implements UserInterface
{
    private $user;

    private $datatables;

    private $hash;

    private $arr;

    public function __construct()
    {
        $this->user = new User;
        $this->datatables = new Datatables;
        $this->hash = new Hash;
        $this->arr = new Arr;
    }

    public function getDataTable()
    {
        if (isSuperAdmin()) {
            $query = $this->user->query();
        } else {
            $query = $this->user->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'Super Admin');
            });
        }

        return $this->datatables->of($query)
            ->addColumn('action', function ($user) {
                $action = '<ul class="action">';

                // Check if the user has a Super Admin role
                if ($user->hasRole('Super Admin')) {
                    // Only show edit button for Super Admin
                    if (isSuperAdmin()) {
                        $action .= '<li class="edit"><a href="'.route('users.edit', $user->id).'"><i class="icon-pencil-alt"></i></a></li>';
                    }
                } else {
                    // Show edit and delete buttons for non-Super Admin users
                    $action .= '<li class="edit"><a href="'.route('users.edit', $user->id).'"><i class="icon-pencil-alt"></i></a></li>';
                    $action .= '<li class="delete"><a data-id="'.$user->id.'" id="deleteUser"><i class="icon-trash"></i></a></li>';
                }

                $action .= '</ul>';

                return $action;
            })
            ->addColumn('name', function ($user) {
                return $user->full_name;
            })
            ->rawColumns(['action', 'photo', 'name'])
            ->toJson();
    }

    public function saveUser($request)
    {
        $input = $request->all();

        if (empty($input['email'])) {
            $input['email'] = 'user_' . time() . '@milecouriers.com';
        }

        if (empty($input['password'])) {
            $input['password'] = Str::random(10);
        } else {
            $input['password'] = $this->hash::make($input['password']);
        }

        $user = $this->user->create($input);

        return $user;
    }

    public function getUser($user_id)
    {
        return $this->user->find($user_id);
    }

    public function updateUser($request, $id)
    {
        $input = $request->all();
        
        if (! empty($input['password'])) {
            $input['password'] = $this->hash::make($input['password']);
        } else {
            $input = $this->arr->except($input, ['password']);
        }

        if (empty($input['email'])) {
            $input['email'] = 'user_' . time() . '@milecouriers.com';
        }

        $this->user->find($id)->update($input);

        return $this->user->find($id);
    }

    public function getUsers()
    {
        return $this->user->all();
    }

    public function deleteUser($id)
    {
        // Find the user by ID
        $user = $this->user->findOrFail($id);

        // Delete the user
        $user->delete();
    }

}
