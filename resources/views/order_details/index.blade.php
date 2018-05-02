@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-align-justify"></i> OrderDetail
                    <a class="btn btn-success pull-right" href="{{ route('order_details.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
                </h1>
            </div>

            <div class="panel-body">
                @if($order_details->count())
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Order_id</th> <th>Third_order_id</th> <th>App_food_code</th> <th>Food_name</th> <th>Sku_id</th> <th>Quantity</th> <th>Price</th> <th>Box_num</th> <th>Box_price</th> <th>Unit</th> <th>Food_discount</th>
                                <th class="text-right">OPTIONS</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($order_details as $order_detail)
                                <tr>
                                    <td class="text-center"><strong>{{$order_detail->id}}</strong></td>

                                    <td>{{$order_detail->order_id}}</td> <td>{{$order_detail->third_order_id}}</td> <td>{{$order_detail->app_food_code}}</td> <td>{{$order_detail->food_name}}</td> <td>{{$order_detail->sku_id}}</td> <td>{{$order_detail->quantity}}</td> <td>{{$order_detail->price}}</td> <td>{{$order_detail->box_num}}</td> <td>{{$order_detail->box_price}}</td> <td>{{$order_detail->unit}}</td> <td>{{$order_detail->food_discount}}</td>
                                    
                                    <td class="text-right">
                                        <a class="btn btn-xs btn-primary" href="{{ route('order_details.show', $order_detail->id) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i> 
                                        </a>
                                        
                                        <a class="btn btn-xs btn-warning" href="{{ route('order_details.edit', $order_detail->id) }}">
                                            <i class="glyphicon glyphicon-edit"></i> 
                                        </a>

                                        <form action="{{ route('order_details.destroy', $order_detail->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                            {{csrf_field()}}
                                            <input type="hidden" name="_method" value="DELETE">

                                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $order_details->render() !!}
                @else
                    <h3 class="text-center alert alert-info">Empty!</h3>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection