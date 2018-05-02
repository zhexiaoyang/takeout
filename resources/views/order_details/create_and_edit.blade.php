@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> OrderDetail /
                    @if($order_detail->id)
                        Edit #{{$order_detail->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($order_detail->id)
                    <form action="{{ route('order_details.update', $order_detail->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('order_details.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                    <label for="order_id-field">Order_id</label>
                    <input class="form-control" type="text" name="order_id" id="order_id-field" value="{{ old('order_id', $order_detail->order_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="third_order_id-field">Third_order_id</label>
                    <input class="form-control" type="text" name="third_order_id" id="third_order_id-field" value="{{ old('third_order_id', $order_detail->third_order_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="app_food_code-field">App_food_code</label>
                    <input class="form-control" type="text" name="app_food_code" id="app_food_code-field" value="{{ old('app_food_code', $order_detail->app_food_code ) }}" />
                </div> 
                <div class="form-group">
                	<label for="food_name-field">Food_name</label>
                	<input class="form-control" type="text" name="food_name" id="food_name-field" value="{{ old('food_name', $order_detail->food_name ) }}" />
                </div> 
                <div class="form-group">
                	<label for="sku_id-field">Sku_id</label>
                	<input class="form-control" type="text" name="sku_id" id="sku_id-field" value="{{ old('sku_id', $order_detail->sku_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="quantity-field">Quantity</label>
                    <input class="form-control" type="text" name="quantity" id="quantity-field" value="{{ old('quantity', $order_detail->quantity ) }}" />
                </div> 
                <div class="form-group">
                    <label for="price-field">Price</label>
                    <input class="form-control" type="text" name="price" id="price-field" value="{{ old('price', $order_detail->price ) }}" />
                </div> 
                <div class="form-group">
                    <label for="box_num-field">Box_num</label>
                    <input class="form-control" type="text" name="box_num" id="box_num-field" value="{{ old('box_num', $order_detail->box_num ) }}" />
                </div> 
                <div class="form-group">
                    <label for="box_price-field">Box_price</label>
                    <input class="form-control" type="text" name="box_price" id="box_price-field" value="{{ old('box_price', $order_detail->box_price ) }}" />
                </div> 
                <div class="form-group">
                    <label for="unit-field">Unit</label>
                    <input class="form-control" type="text" name="unit" id="unit-field" value="{{ old('unit', $order_detail->unit ) }}" />
                </div> 
                <div class="form-group">
                    <label for="food_discount-field">Food_discount</label>
                    <input class="form-control" type="text" name="food_discount" id="food_discount-field" value="{{ old('food_discount', $order_detail->food_discount ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('order_details.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection