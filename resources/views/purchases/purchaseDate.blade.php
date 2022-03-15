@extends('layouts.admin')

@section('content')
<div class = "container">
    <a href="/purchases" class='btn btn-default'><i class="far fa-hand-point-left"></i> Go Back</a> <br>
    <h1 align="center">Purchase on: {{$purchase->purchase_date}}</h1>
    <hr>
    
        {{-- <p align="right"> <b> Date: {{$order->order_date}} </b> </p> <br> --}}
          
        <table class= "table table-responsive table-condensed table-hover table-striped table-bordered table-sm">
            <tr><b>
                <th>Bill Id</th>
                <th>Supplier</th>
                <th>Product</th>
                <th>Quantiy</th>
                <th>Cost Price</th>
                <th>Total Cost</th>
                <th>Paid Amount</th>
                <th>Due Amount</th>
                <th>Written By</th>
                {{-- <th>Action</th> --}}
            </b></tr>
            @foreach($purchases as $purchase)
                <tr>
                    <td>{{$purchase->pbill_id}}</td>
                    <td>{{$purchase->supplier}}</td>
                    <td>{{$purchase->product}}</td>
                    <td>{{$purchase->stock}}</td>
                    <td>{{$purchase->cost_price}}</td>
                    <td>{{$purchase->total_cost}}</td>
                    <td>{{$purchase->paid_amount}}</td>
                    <td>{{$purchase->due_amount}}</td>
                    <td>{{$purchase->user->name}}</td>

                    {{-- <td>
                        <div class='row-fluid'>
                            @if(!Auth::guest())
                                @if(Auth::user()->id == $purchase->user_id)
                                    <a href="/purchases/{{$purchase->id}}/edit" class="btn btn-secondary" style="display:inline-block">Edit</a> --}}
                                    {{-- For Delete --}}
                                    {{-- {!!Form::open(['action' => ['PurchasesController@destroy', $purchase->id], 'method' => 'POST', 'class' => 'pull-right', 'style'=>'display:inline-block'])!!}
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