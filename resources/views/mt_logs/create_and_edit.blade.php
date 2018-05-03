@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> MtLog /
                    @if($mt_log->id)
                        Edit #{{$mt_log->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($mt_log->id)
                    <form action="{{ route('mt_logs.update', $mt_log->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('mt_logs.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                	<label for="api-field">Api</label>
                	<input class="form-control" type="text" name="api" id="api-field" value="{{ old('api', $mt_log->api ) }}" />
                </div> 
                <div class="form-group">
                	<label for="request-field">Request</label>
                	<textarea name="request" id="request-field" class="form-control" rows="3">{{ old('request', $mt_log->request ) }}</textarea>
                </div> 
                <div class="form-group">
                	<label for="response-field">Response</label>
                	<textarea name="response" id="response-field" class="form-control" rows="3">{{ old('response', $mt_log->response ) }}</textarea>
                </div> 
                <div class="form-group">
                    <label for="type-field">Type</label>
                    <input class="form-control" type="text" name="type" id="type-field" value="{{ old('type', $mt_log->type ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('mt_logs.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection