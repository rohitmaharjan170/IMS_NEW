@extends('layouts.admin')

@section('content')
<style>
    .three-inline-buttons .button {
        margin-left: 1px;
        margin-right: 15px;
    }

    .three-inline-buttons {
        display: table;
        margin: 0 auto;
    }

    @media only screen and (max-width: 960px) {

        .three-inline-buttons .button{
            width: 100%;
            margin: 20px;
            text-align: center;
        }
        
    }
    .formkolagi {
        margin-left: 500px;
        margin-right: 0px;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

{{-- FOR DATE PICKER --}}
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="container">
    <h1 align="center">Sales</h1>
    <hr>
    {!! Form::open(['action' => 'OrdersController@export', 'method' => 'GET']) !!}    
    <div class="form-row formkolagi input-daterange float-right" style="margin-right: 0px;">
        <div class = "col-md-4.5 mb-3">
            {{Form::text('from_date', '', ['readonly'=>'readonly', 'class' => 'form-control', 'id' => 'from_date', 'placeholder' => 'From Date'])}}
        </div>
        <div class = "col-md-4.5 mb-3">
            {{Form::text('to_date', '', ['readonly'=>'readonly', 'class' => 'form-control', 'id' => 'to_date', 'placeholder' => 'To Date'])}}
        </div>
        <div class = "col-md-2.5 mb-3">
            {{-- <a href="{{action('OrdersController@export')}}" class="btn btn-default" style="float: middle;">Export</a> --}}
            <button type="submit" class = 'btn btn-success' href="{{action('OrdersController@export')}}"><i class="fa fa-file-excel"></i>&nbsp; &nbsp;Export</button>
        </div>
        {{-- {{Form::submit('Submit', ['class' => 'btn btn-primary'])}} --}}
    </div>
    {!! Form::close() !!}
<br>
<br>
    <hr>
    <a href="/orders/create" class='btn bg-gradient-primary'><i class="fas fa-plus"></i> &nbsp;&nbsp;Add Sale</a>
    <div class="three-inline-buttons" style="float: right;">
        <p>
            
            <a href="/orders/pay_up" class='one-third button btn bg-gradient-info' style="float: right;"><i class="fas fa-dollar-sign"></i>&nbsp;&nbsp;Payments</a>
            <a href="/orders/due" class='one-third button btn bg-gradient-teal' style="float: middle;"><i class="fas fa-hand-holding-usd"></i>&nbsp;  Due Amounts</a>
            
        </p>
    </div>
    {{-- <a href="/orders/create" class='btn btn-primary'>Add Order</a>
    <a href="/orders/pay_up" class='btn btn-info' style="float: right;">Payments</a>
    <a href="/orders/due" class='btn bg-gradient-teal' style="float: middle;">Due</a> --}}
    
    <hr>
    @if(count($orders) > 0)
    <div style="overflow-x:auto;">

        <table class= "table table-responsive table-condensed table-hover table-striped table-bordered table-sm">
            <tr>
                {{-- <th style="text-align:center">Type</th> --}}
                <th style="text-align:center">Bill Id</th>
                <th style="text-align:center">Sale Date</th>
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
                    {{-- <td><a href="/due/{{$order->due_amount}}">{{$order->due_amount}}</a></td> --}}
                    <td>{{$order->due_amount}}</td>
                    {{-- <td>{{$order->user->name}}</td> --}}

                    <td style='white-space: nowrap'>
                        <div class='row-fluid'>
                            <div class="col-md-12 offset-md-0">

                            @if(!Auth::guest())
                                @if(Auth::user()->id == $order->user_id | Auth::user()->is_admin == 1)
                                    {{-- <a href="/orders/{{$order->bill_id}}/edit" class="btn btn-secondary" style="display:inline-block">Edit</a> --}}
                                    <a href="/orders/{{$order->bill_id}}/payment" class="btn btn-info btn-sm"><i class="fas fa-dollar-sign"></i> Edit Payment</a>
                                    {{-- For Delete --}}
                                    {!!Form::open(['class'=>'delete','action' => ['OrdersController@destroy', $order->bill_id], 'method' => 'POST', 'style' => 'display:inline-block'])!!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                        {{-- {{Form::submit('Delete', ['class' => 'btn btn-danger'])}} --}}
                                        <button class="delete btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</button>
                                    {!!Form::close()!!}
                                @else
                                    <p>Not Authorized</p>
                                @endif
                            @endif
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>  
        <br>
        {{$orders->links()}}
    @else
        <p>There are currently no order.</p>
    @endif  
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    {{-- FOR DATE PICKER --}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        //Date Picker
        $( function($) {
            // $('#purchase_date').datepicker({
            //     dateFormat: 'yy-mm-dd'
            // });
            $("#from_date").datepicker(({
                dateFormat: 'yy-mm-dd'
            }));    

            $("#to_date").datepicker(({
                dateFormat: 'yy-mm-dd'
            }));    
        }); 
        
        $(".delete").on("submit", function(){
            return confirm("Are you sure you wanna delete this record?");
        });
    </script>
    </div>
@endsection