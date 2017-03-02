<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function before(User $authUser, $ability, $role = null)
    {
        if ($authUser->can('manage-roles')) {
            return true;
        }
    }
}
