@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Order / Show #{{ $order->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('orders.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('orders.edit', $order->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Order_id</label>
<p>
	{{ $order->order_id }}
</p> <label>Wm_order_id_view</label>
<p>
	{{ $order->wm_order_id_view }}
</p> <label>App_poi_code</label>
<p>
	{{ $order->app_poi_code }}
</p> <label>Wm_poi_name</label>
<p>
	{{ $order->wm_poi_name }}
</p> <label>Wm_poi_address</label>
<p>
	{{ $order->wm_poi_address }}
</p> <label>Wm_poi_phone</label>
<p>
	{{ $order->wm_poi_phone }}
</p> <label>Recipient_address</label>
<p>
	{{ $order->recipient_address }}
</p> <label>Recipient_phone</label>
<p>
	{{ $order->recipient_phone }}
</p> <label>Recipient_name</label>
<p>
	{{ $order->recipient_name }}
</p> <label>Shipping_fee</label>
<p>
	{{ $order->shipping_fee }}
</p> <label>Total</label>
<p>
	{{ $order->total }}
</p> <label>Original_price</label>
<p>
	{{ $order->original_price }}
</p> <label>Caution</label>
<p>
	{{ $order->caution }}
</p> <label>Shipper_phone</label>
<p>
	{{ $order->shipper_phone }}
</p> <label>Status</label>
<p>
	{{ $order->status }}
</p> <label>City_id</label>
<p>
	{{ $order->city_id }}
</p> <label>Has_invoiced</label>
<p>
	{{ $order->has_invoiced }}
</p> <label>Invoice_title</label>
<p>
	{{ $order->invoice_title }}
</p> <label>Taxpayer_id</label>
<p>
	{{ $order->taxpayer_id }}
</p> <label>Ctime</label>
<p>
	{{ $order->ctime }}
</p> <label>Utime</label>
<p>
	{{ $order->utime }}
</p> <label>Delivery_time</label>
<p>
	{{ $order->delivery_time }}
</p> <label>Is_third_shipping</label>
<p>
	{{ $order->is_third_shipping }}
</p> <label>Pay_type</label>
<p>
	{{ $order->pay_type }}
</p> <label>Pick_type</label>
<p>
	{{ $order->pick_type }}
</p> <label>Latitude</label>
<p>
	{{ $order->latitude }}
</p> <label>Longitude</label>
<p>
	{{ $order->longitude }}
</p> <label>Day_seq</label>
<p>
	{{ $order->day_seq }}
</p> <label>Is_favorites</label>
<p>
	{{ $order->is_favorites }}
</p> <label>Is_poi_first_order</label>
<p>
	{{ $order->is_poi_first_order }}
</p> <label>Dinners_number</label>
<p>
	{{ $order->dinners_number }}
</p> <label>Logistics_code</label>
<p>
	{{ $order->logistics_code }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection
