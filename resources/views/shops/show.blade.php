@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Shop / Show #{{ $shop->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('shops.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('shops.edit', $shop->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Name</label>
<p>
	{{ $shop->name }}
</p> <label>Address</label>
<p>
	{{ $shop->address }}
</p> <label>Latitude</label>
<p>
	{{ $shop->latitude }}
</p> <label>Longitude</label>
<p>
	{{ $shop->longitude }}
</p> <label>Pic_url</label>
<p>
	{{ $shop->pic_url }}
</p> <label>Pic_url_large</label>
<p>
	{{ $shop->pic_url_large }}
</p> <label>Phone</label>
<p>
	{{ $shop->phone }}
</p> <label>Standby_tel</label>
<p>
	{{ $shop->standby_tel }}
</p> <label>Shipping_fee</label>
<p>
	{{ $shop->shipping_fee }}
</p> <label>Shipping_time</label>
<p>
	{{ $shop->shipping_time }}
</p> <label>Promotion_info</label>
<p>
	{{ $shop->promotion_info }}
</p> <label>Open_level</label>
<p>
	{{ $shop->open_level }}
</p> <label>Is_online</label>
<p>
	{{ $shop->is_online }}
</p> <label>Invoice_support</label>
<p>
	{{ $shop->invoice_support }}
</p> <label>Invoice_min_price</label>
<p>
	{{ $shop->invoice_min_price }}
</p> <label>Invoice_description</label>
<p>
	{{ $shop->invoice_description }}
</p> <label>Third_tag_name</label>
<p>
	{{ $shop->third_tag_name }}
</p> <label>Pre_book</label>
<p>
	{{ $shop->pre_book }}
</p> <label>Time_select</label>
<p>
	{{ $shop->time_select }}
</p> <label>App_brand_code</label>
<p>
	{{ $shop->app_brand_code }}
</p> <label>Mt_type_id</label>
<p>
	{{ $shop->mt_type_id }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection
