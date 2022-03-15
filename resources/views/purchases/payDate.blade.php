@extends('layouts.admin')

@section('content')
<div class = "container">
    <a href="/purchases/pay_up" class='btn btn-default'><i class="far fa-hand-point-left"></i> Go Back</a> <br>
    <h1 align="center">Payments on: {{$payment->payment_date}}</h1>
    <hr>
    
        {{-- <p align="right"> <b> Date: {{$order->order_date}} </b> </p> <br> --}}
          
        <table class= "table table-responsive table-condensed table-hover table-striped table-bordered table-sm">
            <tr><b>
                <th>Payment Date</th>
                <th>Bill Date</th>
                <th>Bill Id</th>
                <th>Supplier</th>
                <th>Total Cost</th>
                <th>Previous Due Amount</th>

                <th>Paid Amount</th>
                <th>Current Due Amount</th>
            </b></tr>
            @foreach($payments as $payment)
            <tr>
                <tr style="text-align:center">
                    <td><a href="/pay_date/{{$payment->payment_date}}">{{$payment->payment_date}}</a></td>
                    <td>{{$payment->bill_date}}</td>
                    <td><a href="/purchase_bill/{{$payment->pbill_id}}">{{$payment->pbill_id}}</a></td>
                    <td>{{$payment->supplier}}</td>
                    <td>{{$payment->total_cost}}</td>
                    <td>{{$payment->prev_due_amount}}</td>
                    <td><b>{{$payment->paid_amount}}</b></td>
                    <td>{{$payment->due_amount}}</td>
                
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