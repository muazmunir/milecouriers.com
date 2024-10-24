<?php

namespace App\Interfaces;

interface RoleInterface
{
    public function getDataTable();

    public function getRoles();

    public function getUserRoles($user_id);

    public function createRole(array $data);

    public function findRoleById($id);

    public function updateRole($id, array $data): bool;

    public function deleteRole($id): bool;

    public function assignPermissions($roleId, array $permissions): bool;
}
