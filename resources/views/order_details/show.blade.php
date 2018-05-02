@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>OrderDetail / Show #{{ $order_detail->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('order_details.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('order_details.edit', $order_detail->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Order_id</label>
<p>
	{{ $order_detail->order_id }}
</p> <label>Third_order_id</label>
<p>
	{{ $order_detail->third_order_id }}
</p> <label>App_food_code</label>
<p>
	{{ $order_detail->app_food_code }}
</p> <label>Food_name</label>
<p>
	{{ $order_detail->food_name }}
</p> <label>Sku_id</label>
<p>
	{{ $order_detail->sku_id }}
</p> <label>Quantity</label>
<p>
	{{ $order_detail->quantity }}
</p> <label>Price</label>
<p>
	{{ $order_detail->price }}
</p> <label>Box_num</label>
<p>
	{{ $order_detail->box_num }}
</p> <label>Box_price</label>
<p>
	{{ $order_detail->box_price }}
</p> <label>Unit</label>
<p>
	{{ $order_detail->unit }}
</p> <label>Food_discount</label>
<p>
	{{ $order_detail->food_discount }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection
