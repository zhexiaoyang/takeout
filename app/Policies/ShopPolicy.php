<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Shop;

class ShopPolicy extends Policy
{
    public function update(User $user, Shop $shop)
    {
        if ($user->can('shop_edit')) {
            return true;
        }
        return false;
    }

    public function destroy(User $user, Shop $shop)
    {
        return true;
    }
}
