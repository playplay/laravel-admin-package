<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $authUser, $ability, $user = null)
    {
        if ($authUser->can('manage-users')) {
            return true;
        }

        if (in_array($ability, ['view', 'update'])) {
            /** @var User $user */
            return $authUser->is($user);
        };
    }
}
