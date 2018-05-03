<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MtLog;

class MtLogPolicy extends Policy
{
    public function update(User $user, MtLog $mt_log)
    {
        // return $mt_log->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, MtLog $mt_log)
    {
        return true;
    }
}
