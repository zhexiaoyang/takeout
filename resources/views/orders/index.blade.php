@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-align-justify"></i> Order
                    <a class="btn btn-success pull-right" href="{{ route('orders.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
                </h1>
            </div>

            <div class="panel-body">
                @if($orders->count())
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Order_id</th> <th>Wm_order_id_view</th> <th>App_poi_code</th> <th>Wm_poi_name</th> <th>Wm_poi_address</th> <th>Wm_poi_phone</th> <th>Recipient_address</th> <th>Recipient_phone</th> <th>Recipient_name</th> <th>Shipping_fee</th> <th>Total</th> <th>Original_price</th> <th>Caution</th> <th>Shipper_phone</th> <th>Status</th> <th>City_id</th> <th>Has_invoiced</th> <th>Invoice_title</th> <th>Taxpayer_id</th> <th>Ctime</th> <th>Utime</th> <th>Delivery_time</th> <th>Is_third_shipping</th> <th>Pay_type</th> <th>Pick_type</th> <th>Latitude</th> <th>Longitude</th> <th>Day_seq</th> <th>Is_favorites</th> <th>Is_poi_first_order</th> <th>Dinners_number</th> <th>Logistics_code</th>
                                <th class="text-right">OPTIONS</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="text-center"><strong>{{$order->id}}</strong></td>

                                    <td>{{$order->order_id}}</td> <td>{{$order->wm_order_id_view}}</td> <td>{{$order->app_poi_code}}</td> <td>{{$order->wm_poi_name}}</td> <td>{{$order->wm_poi_address}}</td> <td>{{$order->wm_poi_phone}}</td> <td>{{$order->recipient_address}}</td> <td>{{$order->recipient_phone}}</td> <td>{{$order->recipient_name}}</td> <td>{{$order->shipping_fee}}</td> <td>{{$order->total}}</td> <td>{{$order->original_price}}</td> <td>{{$order->caution}}</td> <td>{{$order->shipper_phone}}</td> <td>{{$order->status}}</td> <td>{{$order->city_id}}</td> <td>{{$order->has_invoiced}}</td> <td>{{$order->invoice_title}}</td> <td>{{$order->taxpayer_id}}</td> <td>{{$order->ctime}}</td> <td>{{$order->utime}}</td> <td>{{$order->delivery_time}}</td> <td>{{$order->is_third_shipping}}</td> <td>{{$order->pay_type}}</td> <td>{{$order->pick_type}}</td> <td>{{$order->latitude}}</td> <td>{{$order->longitude}}</td> <td>{{$order->day_seq}}</td> <td>{{$order->is_favorites}}</td> <td>{{$order->is_poi_first_order}}</td> <td>{{$order->dinners_number}}</td> <td>{{$order->logistics_code}}</td>
                                    
                                    <td class="text-right">
                                        <a class="btn btn-xs btn-primary" href="{{ route('orders.show', $order->id) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i> 
                                        </a>
                                        
                                        <a class="btn btn-xs btn-warning" href="{{ route('orders.edit', $order->id) }}">
                                            <i class="glyphicon glyphicon-edit"></i> 
                                        </a>

                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                            {{csrf_field()}}
                                            <input type="hidden" name="_method" value="DELETE">

                                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $orders->render() !!}
                @else
                    <h3 class="text-center alert alert-info">Empty!</h3>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection