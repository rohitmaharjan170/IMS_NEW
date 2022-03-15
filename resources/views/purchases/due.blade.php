@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 align="center">Due Amounts</h1>
    <hr>
    {{-- <a href="/orders/create" class='btn btn-primary'>Add Order</a>
    <a href="/orders/pay_up" class='btn btn-info' style="float: right;">Payments</a> --}}
    <a href="/purchases" class='btn btn-default' style="display:inline-block"><i class="far fa-hand-point-left"></i> Go Back</a>

    <hr>
    @if(count($purchases) > 0)
        <table class= "table table-responsive table-condensed table-hover table-striped table-bordered table-sm">
            <tr>
                {{-- <th style="text-align:center">Type</th> --}}
                <th style="text-align:center">Bill Id</th>
                <th style="text-align:center">Date</th>
                <th style="text-align:center">Supplier</th>
                <th style="text-align:center">Product</th>
                <th style="text-align:center">Quantity</th>
                <th style="text-align:center">Cost Price</th>
                <th style="text-align:center">Total Cost</th>
                <th style="text-align:center">Paid Amount</th>
                <th style="text-align:center">Due Amount</th>
                {{-- <th style="text-align:center">Written By</th> --}}
                <th style="text-align:center">Action</th>
            </tr>
            @foreach($purchases as $purchase)
                {{-- @if($order->due_amount > 0) --}}
                    <tr style="text-align:center">
                        {{-- <td>{{$order->type}}</td> --}}
                        <td>{{$purchase->pbill_id}}</td>
                        <td>{{$purchase->purchase_date}}</td>
                        <td>{{$purchase->supplier}}</td>                    
                        <td>{{$purchase->product}}</td>                    
                        
                        <td>{{$purchase->stock}}</td>
                        <td>{{$purchase->cost_price}}</td>
                        <td>{{$purchase->total_cost}}</td>
                        
                        <td>{{$purchase->paid_amount}}</td>
                        <td><b>{{$purchase->due_amount}}</b></td>
                        {{-- <td>{{$order->user->name}}</td> --}}

                        <td>
                            <div class='row-fluid'>
                                @if(!Auth::guest())
                                    @if(Auth::user()->id == $purchase->user_id | Auth::user()->is_admin == 1)
                                        {{-- <a href="/purchases/{{$purchase->pbill_id}}/edit" class="btn btn-secondary" style="display:inline-block">Edit</a> --}}
                                        {{-- For Delete --}}
                                        {{-- {!!Form::open(['class'=>'delete','action' => ['PurchasesController@destroy', $purchase->id], 'method' => 'POST', 'style' => 'display:inline-block'])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                        {!!Form::close()!!} --}}

                                        <a href="/purchases/{{$purchase->pbill_id}}/payment" class="btn btn-info"><i class="fas fa-dollar-sign"></i> Edit Payment</a>

                                        @else
                                        <p>Not Authorized</p>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                {{-- @endif --}}
            @endforeach
        </table>
        {{$purchases->links()}} 
    @else
        <p>There are currently no order.</p>
    @endif    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script>
        $(".delete").on("submit", function(){
            return confirm("Are you sure you wanna delete this bro?");
        });
    </script>
    </div>
@endsection