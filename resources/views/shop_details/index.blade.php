@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-align-justify"></i> ShopDetail
                    <a class="btn btn-success pull-right" href="{{ route('shop_details.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
                </h1>
            </div>

            <div class="panel-body">
                @if($shop_details->count())
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Shop_id</th> <th>Opening_bank</th> <th>Username</th> <th>Account_number</th> <th>Is_invoice</th> <th>Type</th> <th>Name</th> <th>Number</th> <th>Coefficient</th>
                                <th class="text-right">OPTIONS</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($shop_details as $shop_detail)
                                <tr>
                                    <td class="text-center"><strong>{{$shop_detail->id}}</strong></td>

                                    <td>{{$shop_detail->shop_id}}</td> <td>{{$shop_detail->opening_bank}}</td> <td>{{$shop_detail->username}}</td> <td>{{$shop_detail->account_number}}</td> <td>{{$shop_detail->is_invoice}}</td> <td>{{$shop_detail->type}}</td> <td>{{$shop_detail->name}}</td> <td>{{$shop_detail->number}}</td> <td>{{$shop_detail->coefficient}}</td>
                                    
                                    <td class="text-right">
                                        <a class="btn btn-xs btn-primary" href="{{ route('shop_details.show', $shop_detail->id) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i> 
                                        </a>
                                        
                                        <a class="btn btn-xs btn-warning" href="{{ route('shop_details.edit', $shop_detail->id) }}">
                                            <i class="glyphicon glyphicon-edit"></i> 
                                        </a>

                                        <form action="{{ route('shop_details.destroy', $shop_detail->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                            {{csrf_field()}}
                                            <input type="hidden" name="_method" value="DELETE">

                                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $shop_details->render() !!}
                @else
                    <h3 class="text-center alert alert-info">Empty!</h3>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection