@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Order /
                    @if($order->id)
                        Edit #{{$order->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($order->id)
                    <form action="{{ route('orders.update', $order->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('orders.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                    <label for="order_id-field">Order_id</label>
                    <input class="form-control" type="text" name="order_id" id="order_id-field" value="{{ old('order_id', $order->order_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="wm_order_id_view-field">Wm_order_id_view</label>
                    <input class="form-control" type="text" name="wm_order_id_view" id="wm_order_id_view-field" value="{{ old('wm_order_id_view', $order->wm_order_id_view ) }}" />
                </div> 
                <div class="form-group">
                	<label for="app_poi_code-field">App_poi_code</label>
                	<input class="form-control" type="text" name="app_poi_code" id="app_poi_code-field" value="{{ old('app_poi_code', $order->app_poi_code ) }}" />
                </div> 
                <div class="form-group">
                	<label for="wm_poi_name-field">Wm_poi_name</label>
                	<input class="form-control" type="text" name="wm_poi_name" id="wm_poi_name-field" value="{{ old('wm_poi_name', $order->wm_poi_name ) }}" />
                </div> 
                <div class="form-group">
                	<label for="wm_poi_address-field">Wm_poi_address</label>
                	<input class="form-control" type="text" name="wm_poi_address" id="wm_poi_address-field" value="{{ old('wm_poi_address', $order->wm_poi_address ) }}" />
                </div> 
                <div class="form-group">
                	<label for="wm_poi_phone-field">Wm_poi_phone</label>
                	<input class="form-control" type="text" name="wm_poi_phone" id="wm_poi_phone-field" value="{{ old('wm_poi_phone', $order->wm_poi_phone ) }}" />
                </div> 
                <div class="form-group">
                	<label for="recipient_address-field">Recipient_address</label>
                	<input class="form-control" type="text" name="recipient_address" id="recipient_address-field" value="{{ old('recipient_address', $order->recipient_address ) }}" />
                </div> 
                <div class="form-group">
                	<label for="recipient_phone-field">Recipient_phone</label>
                	<input class="form-control" type="text" name="recipient_phone" id="recipient_phone-field" value="{{ old('recipient_phone', $order->recipient_phone ) }}" />
                </div> 
                <div class="form-group">
                	<label for="recipient_name-field">Recipient_name</label>
                	<input class="form-control" type="text" name="recipient_name" id="recipient_name-field" value="{{ old('recipient_name', $order->recipient_name ) }}" />
                </div> 
                <div class="form-group">
                    <label for="shipping_fee-field">Shipping_fee</label>
                    <input class="form-control" type="text" name="shipping_fee" id="shipping_fee-field" value="{{ old('shipping_fee', $order->shipping_fee ) }}" />
                </div> 
                <div class="form-group">
                    <label for="total-field">Total</label>
                    <input class="form-control" type="text" name="total" id="total-field" value="{{ old('total', $order->total ) }}" />
                </div> 
                <div class="form-group">
                    <label for="original_price-field">Original_price</label>
                    <input class="form-control" type="text" name="original_price" id="original_price-field" value="{{ old('original_price', $order->original_price ) }}" />
                </div> 
                <div class="form-group">
                	<label for="caution-field">Caution</label>
                	<input class="form-control" type="text" name="caution" id="caution-field" value="{{ old('caution', $order->caution ) }}" />
                </div> 
                <div class="form-group">
                	<label for="shipper_phone-field">Shipper_phone</label>
                	<input class="form-control" type="text" name="shipper_phone" id="shipper_phone-field" value="{{ old('shipper_phone', $order->shipper_phone ) }}" />
                </div> 
                <div class="form-group">
                    <label for="status-field">Status</label>
                    <input class="form-control" type="text" name="status" id="status-field" value="{{ old('status', $order->status ) }}" />
                </div> 
                <div class="form-group">
                    <label for="city_id-field">City_id</label>
                    <input class="form-control" type="text" name="city_id" id="city_id-field" value="{{ old('city_id', $order->city_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="has_invoiced-field">Has_invoiced</label>
                    <input class="form-control" type="text" name="has_invoiced" id="has_invoiced-field" value="{{ old('has_invoiced', $order->has_invoiced ) }}" />
                </div> 
                <div class="form-group">
                	<label for="invoice_title-field">Invoice_title</label>
                	<input class="form-control" type="text" name="invoice_title" id="invoice_title-field" value="{{ old('invoice_title', $order->invoice_title ) }}" />
                </div> 
                <div class="form-group">
                	<label for="taxpayer_id-field">Taxpayer_id</label>
                	<input class="form-control" type="text" name="taxpayer_id" id="taxpayer_id-field" value="{{ old('taxpayer_id', $order->taxpayer_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="ctime-field">Ctime</label>
                    <input class="form-control" type="text" name="ctime" id="ctime-field" value="{{ old('ctime', $order->ctime ) }}" />
                </div> 
                <div class="form-group">
                    <label for="utime-field">Utime</label>
                    <input class="form-control" type="text" name="utime" id="utime-field" value="{{ old('utime', $order->utime ) }}" />
                </div> 
                <div class="form-group">
                    <label for="delivery_time-field">Delivery_time</label>
                    <input class="form-control" type="text" name="delivery_time" id="delivery_time-field" value="{{ old('delivery_time', $order->delivery_time ) }}" />
                </div> 
                <div class="form-group">
                    <label for="is_third_shipping-field">Is_third_shipping</label>
                    <input class="form-control" type="text" name="is_third_shipping" id="is_third_shipping-field" value="{{ old('is_third_shipping', $order->is_third_shipping ) }}" />
                </div> 
                <div class="form-group">
                    <label for="pay_type-field">Pay_type</label>
                    <input class="form-control" type="text" name="pay_type" id="pay_type-field" value="{{ old('pay_type', $order->pay_type ) }}" />
                </div> 
                <div class="form-group">
                    <label for="pick_type-field">Pick_type</label>
                    <input class="form-control" type="text" name="pick_type" id="pick_type-field" value="{{ old('pick_type', $order->pick_type ) }}" />
                </div> 
                <div class="form-group">
                    <label for="latitude-field">Latitude</label>
                    <input class="form-control" type="text" name="latitude" id="latitude-field" value="{{ old('latitude', $order->latitude ) }}" />
                </div> 
                <div class="form-group">
                    <label for="longitude-field">Longitude</label>
                    <input class="form-control" type="text" name="longitude" id="longitude-field" value="{{ old('longitude', $order->longitude ) }}" />
                </div> 
                <div class="form-group">
                    <label for="day_seq-field">Day_seq</label>
                    <input class="form-control" type="text" name="day_seq" id="day_seq-field" value="{{ old('day_seq', $order->day_seq ) }}" />
                </div> 
                <div class="form-group">
                    <label for="is_favorites-field">Is_favorites</label>
                    <input class="form-control" type="text" name="is_favorites" id="is_favorites-field" value="{{ old('is_favorites', $order->is_favorites ) }}" />
                </div> 
                <div class="form-group">
                    <label for="is_poi_first_order-field">Is_poi_first_order</label>
                    <input class="form-control" type="text" name="is_poi_first_order" id="is_poi_first_order-field" value="{{ old('is_poi_first_order', $order->is_poi_first_order ) }}" />
                </div> 
                <div class="form-group">
                    <label for="dinners_number-field">Dinners_number</label>
                    <input class="form-control" type="text" name="dinners_number" id="dinners_number-field" value="{{ old('dinners_number', $order->dinners_number ) }}" />
                </div> 
                <div class="form-group">
                	<label for="logistics_code-field">Logistics_code</label>
                	<input class="form-control" type="text" name="logistics_code" id="logistics_code-field" value="{{ old('logistics_code', $order->logistics_code ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('orders.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection