<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OrderDetail;

class OrderDetailPolicy extends Policy
{
    public function update(User $user, OrderDetail $order_detail)
    {
        // return $order_detail->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, OrderDetail $order_detail)
    {
        return true;
    }
}
