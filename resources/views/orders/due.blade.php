@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 align="center">Due Amounts</h1>
    <hr>
    {{-- <a href="/orders/create" class='btn btn-primary'>Add Order</a>
    <a href="/orders/pay_up" class='btn btn-info' style="float: right;">Payments</a> --}}
    <a href="/orders" class='btn btn-default' style="display:inline-block"><i class="far fa-hand-point-left"></i> Go Back</a>

    <hr>
    @if(count($orders) > 0)
        <table class= "table table-responsive table-condensed table-hover table-striped table-bordered table-sm">
            <tr>
                {{-- <th style="text-align:center">Type</th> --}}
                <th style="text-align:center">Bill Id</th>
                <th style="text-align:center">Order Date</th>
                <th style="text-align:center">Client Name</th>
                <th style="text-align:center">Product Name</th>
                <th style="text-align:center">Quantity</th>
                <th style="text-align:center">Rate</th>
                <th style="text-align:center">Sub Amount</th>
                <th style="text-align:center">Discount</th>
                <th style="text-align:center">Grand Total</th>
                <th style="text-align:center">Paid Amount</th>
                <th style="text-align:center">Due Amount</th>
                {{-- <th style="text-align:center">Written By</th> --}}
                <th style="text-align:center">Action</th>
            </tr>
            @foreach($orders as $order)
                {{-- @if($order->due_amount > 0) --}}
                    <tr style="text-align:center">
                        {{-- <td>{{$order->type}}</td> --}}
                        <td><a href="/bill_order/{{$order->bill_id}}">{{$order->bill_id}}</a></td>
                        <td><a href="/order_date/{{$order->order_date}}">{{$order->order_date}}</a></td>
                        <td><a href="/client_order/{{$order->client_name}}">{{$order->client_name}}</a></td>                    
                        <td><a href="/product_order/{{$order->product_name}}">{{$order->product_name}}</a></td>                    
                        
                        <td>{{$order->quantity}}</td>
                        <td>{{$order->rate}}</td>
                        <td>{{$order->sub_amount}}</td>
                        <td>{{$order->discount}}</td>
                        <td>{{$order->grand_total}}</td>
                        <td>{{$order->paid_amount}}</td>
                        <td><b>{{$order->due_amount}}</b></td>
                        {{-- <td>{{$order->user->name}}</td> --}}

                        <td>
                            <div class='row-fluid'>
                                @if(!Auth::guest())
                                    @if(Auth::user()->id == $order->user_id | Auth::user()->is_admin == 1)
                                        {{-- <a href="/orders/{{$order->bill_id}}/edit" class="btn btn-secondary" style="display:inline-block">Edit</a> --}}
                                        <a href="/orders/{{$order->bill_id}}/payment" class="btn btn-info"><i class="fas fa-dollar-sign"></i>  Edit Payment</a>
                                        {{-- For Delete --}}
                                        {{-- {!!Form::open(['class'=>'delete','action' => ['OrdersController@destroy', $order->id], 'method' => 'POST', 'style' => 'display:inline-block'])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                        {!!Form::close()!!} --}}

                                        

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
        {{$orders->links()}} 
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