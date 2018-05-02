<?php

namespace App\Observers;

use App\Models\OrderDetail;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class OrderDetailObserver
{
    public function creating(OrderDetail $order_detail)
    {
        //
    }

    public function updating(OrderDetail $order_detail)
    {
        //
    }
}