<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ShopDetail;

class ShopDetailPolicy extends Policy
{
    public function update(User $user, ShopDetail $shop_detail)
    {
        // return $shop_detail->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, ShopDetail $shop_detail)
    {
        return true;
    }
}
