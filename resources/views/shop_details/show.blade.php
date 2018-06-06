@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>ShopDetail / Show #{{ $shop_detail->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('shop_details.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('shop_details.edit', $shop_detail->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Shop_id</label>
<p>
	{{ $shop_detail->shop_id }}
</p> <label>Opening_bank</label>
<p>
	{{ $shop_detail->opening_bank }}
</p> <label>Username</label>
<p>
	{{ $shop_detail->username }}
</p> <label>Account_number</label>
<p>
	{{ $shop_detail->account_number }}
</p> <label>Is_invoice</label>
<p>
	{{ $shop_detail->is_invoice }}
</p> <label>Type</label>
<p>
	{{ $shop_detail->type }}
</p> <label>Name</label>
<p>
	{{ $shop_detail->name }}
</p> <label>Number</label>
<p>
	{{ $shop_detail->number }}
</p> <label>Coefficient</label>
<p>
	{{ $shop_detail->coefficient }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection
