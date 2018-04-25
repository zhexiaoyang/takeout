@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Good / Show #{{ $good->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('goods.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('goods.edit', $good->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Deopt_id</label>
<p>
	{{ $good->deopt_id }}
</p> <label>Price</label>
<p>
	{{ $good->price }}
</p> <label>Shop_id</label>
<p>
	{{ $good->shop_id }}
</p> <label>Cagegory_id</label>
<p>
	{{ $good->cagegory_id }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection
