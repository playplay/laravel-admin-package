<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function before(User $authUser, $ability, $permission = null)
    {
        if ($authUser->can('manage-permissions')) {
            return true;
        }
    }
}
