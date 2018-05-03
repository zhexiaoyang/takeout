@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>MtLog / Show #{{ $mt_log->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('mt_logs.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('mt_logs.edit', $mt_log->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Api</label>
<p>
	{{ $mt_log->api }}
</p> <label>Request</label>
<p>
	{{ $mt_log->request }}
</p> <label>Response</label>
<p>
	{{ $mt_log->response }}
</p> <label>Type</label>
<p>
	{{ $mt_log->type }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection
