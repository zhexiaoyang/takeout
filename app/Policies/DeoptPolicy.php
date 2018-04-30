<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Deopt;

class DeoptPolicy extends Policy
{
    public function update(User $user, Deopt $deopt)
    {
        // return $deopt->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Deopt $deopt)
    {
        if ($user->can('deopt_delete')) {
            return true;
        }
        return false;
    }
}
