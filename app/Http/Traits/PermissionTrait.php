<?php

namespace App\Http\Traits;

use App\Models\User;

trait PermissionTrait
{

    public function checkPermission($user, $permission)
    {
        $check = User::where('email', $user->email)->first();
        if ($check->getPermissionsViaRoles()->where('name', $permission)->count() == 0) {
            return false;
        }

        return true;
    }

    public function changeRole($user, $name)
    {
        $check = User::where('email', $user->email)->first();
        $check->roles()->detach();
        $check->assignRole($name);
        $check->save();
        return $check->roles->pluck('name');
    }
}
