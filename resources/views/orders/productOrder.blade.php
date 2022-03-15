@extends('layouts.admin')

@section('content')
<div class = "container">
    <a href="/orders" class='btn btn-default'><i class="far fa-hand-point-left"></i> Go Back</a> <br>
    <h1 align="center">{{$order->product_name}} Orders</h1>
    <hr>
    
        {{-- <p align="right"> <b> Date: {{$order->order_date}} </b> </p> <br> --}}
          
        <table class= "table table-responsive table-condensed table-hover table-striped table-bordered table-sm">
            <tr><b>
                <th>Bill Id</th>
                <th>Order Date</th>
                <th>Client Name</th>
                <th>Quantiy</th>
                <th>Rate</th>
                <th>Sub Amount</th>
                <th>Discount</th>
                <th>Grand Total</th>
                <th>Paid Amount</th>
                <th>Due Amount</th>
                {{-- <th>Written By</th> --}}
                {{-- <th>Action</th> --}}
            </b></tr>
            @foreach($orders as $order)
                <tr>
                    <td>{{$order->bill_id}}</td>
                    <td>{{$order->order_date}}</td>
                    <td>{{$order->client_name}}</td>
                    <td>{{$order->quantity}}</td>
                    <td>{{$order->rate}}</td>
                    <td>{{$order->sub_amount}}</td>
                    <td>{{$order->discount}}</td>
                    <td>{{$order->grand_total}}</td>
                    <td>{{$order->paid_amount}}</td>
                    <td>{{$order->due_amount}}</td>
                    {{-- <td>{{$order->user->name}}</td> --}}
                    {{-- <td>
                        <div class='row-fluid'>
                            @if(!Auth::guest())
                                @if(Auth::user()->id == $order->user_id) --}}
                                    {{-- <a href="/orders/{{$order->id}}/edit" class="btn btn-secondary" style="display:inline-block">Edit</a> --}}
                                    {{-- For Delete --}}
                                    {{-- {!!Form::open(['action' => ['OrdersController@destroy', $order->id], 'method' => 'POST', 'class' => 'pull-right', 'style'=>'display:inline-block'])!!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                    {!!Form::close()!!}
                                    @else
                                    <p>Not Authorized</p>
                                @endif
                            @endif
                        </div>
                    </td>                 --}}
                </tr>

            @endforeach
        </table>     
</div>

    {{-- <p align="right"> <b> VAT 13% : </b> {{$order->vat}} </p>
    <p align="right"> <b> Total Amount : </b> {{$order->total_amount}} </p>
    <p align="right"> <b> Discount : </b> {{$order->discount}} </p>
    <p align="right"> <b> Grand Total : {{$order->grand_total}} </b></p>
    <p align="left"> <b> Paid Amount : </b> {{$order->paid_amount}} </p>
    <p align="left"> <b> Due Amount : </b> {{$order->due_amount}} </p>  
    <p align="left"> <b> Product Name: </b> {{$order->product_name}} </p> <br>  --}}
@endsection