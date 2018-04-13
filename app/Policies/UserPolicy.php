<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->can('manage_users')) {
            return true;
        }
        return false;
    }

    public function destroy(User $user)
    {
        return $user->hasPermissionTo('manage_del');
    }
}