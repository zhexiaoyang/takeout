@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Deopt / Show #{{ $deopt->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('deopts.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('deopts.edit', $deopt->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Name</label>
<p>
	{{ $deopt->name }}
</p> <label>Category</label>
<p>
	{{ $deopt->category }}
</p> <label>Unit</label>
<p>
	{{ $deopt->unit }}
</p> <label>Price</label>
<p>
	{{ $deopt->price }}
</p> <label>Spec</label>
<p>
	{{ $deopt->spec }}
</p> <label>Description</label>
<p>
	{{ $deopt->description }}
</p> <label>Approval</label>
<p>
	{{ $deopt->approval }}
</p> <label>Is_otc</label>
<p>
	{{ $deopt->is_otc }}
</p> <label>Upc</label>
<p>
	{{ $deopt->upc }}
</p> <label>Mt_id</label>
<p>
	{{ $deopt->mt_id }}
</p> <label>Status</label>
<p>
	{{ $deopt->status }}
</p> <label>Picture</label>
<p>
	{{ $deopt->picture }}
</p> <label>Common_name</label>
<p>
	{{ $deopt->common_name }}
</p> <label>Company</label>
<p>
	{{ $deopt->company }}
</p> <label>Brand</label>
<p>
	{{ $deopt->brand }}
</p> <label>Yfyl</label>
<p>
	{{ $deopt->yfyl }}
</p> <label>Syz</label>
<p>
	{{ $deopt->syz }}
</p> <label>Syrq</label>
<p>
	{{ $deopt->syrq }}
</p> <label>Cf</label>
<p>
	{{ $deopt->cf }}
</p> <label>Blfy</label>
<p>
	{{ $deopt->blfy }}
</p> <label>Jj</label>
<p>
	{{ $deopt->jj }}
</p> <label>Zysx</label>
<p>
	{{ $deopt->zysx }}
</p> <label>Ypxhzy</label>
<p>
	{{ $deopt->ypxhzy }}
</p> <label>Etyy</label>
<p>
	{{ $deopt->etyy }}
</p> <label>Rsybr</label>
<p>
	{{ $deopt->rsybr }}
</p> <label>Lnryy</label>
<p>
	{{ $deopt->lnryy }}
</p> <label>Xz</label>
<p>
	{{ $deopt->xz }}
</p> <label>Bz</label>
<p>
	{{ $deopt->bz }}
</p> <label>Jx</label>
<p>
	{{ $deopt->jx }}
</p> <label>Zc</label>
<p>
	{{ $deopt->zc }}
</p> <label>Ylzy</label>
<p>
	{{ $deopt->ylzy }}
</p> <label>Yxq</label>
<p>
	{{ $deopt->yxq }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection
