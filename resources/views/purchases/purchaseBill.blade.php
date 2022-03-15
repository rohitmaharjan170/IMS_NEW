@extends('layouts.admin')

@section('content')
<div class = "container">
    <a href="/purchases" class='btn btn-default'><i class="far fa-hand-point-left"></i> Go Back</a> <br>

    <h1 align="center">Supplier: {{$purchase->supplier}}</h1>
    <hr>    
    <p align="right"> <b> Date: {{$purchase->purchase_date}} </b> </p> <br>
    <p align="left"> <b> Purchase Bill Number: </b> {{$purchase->pbill_id}} </p> <br>

    <table class= "table table-responsive table-condensed table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Cost Price</th>
            </tr>
        </thead>

        <tbody>
            @foreach($purchases as $purchase)

            <tr>
                <td>{{$purchase->product}}</td>
                <td>{{$purchase->stock}}</td>
                <td>{{$purchase->cost_price}}</td>
            </tr>

            @endforeach
        </tbody>
    </table>
    <br>

    <p align="right"> <b> Total Cost : {{$purchase->total_cost}} </b> </p>
    <p align="right"> <b> Paid Amount : </b> {{$purchase->paid_amount}} </p>
    <p align="right"> <b> Due Amount : </b> {{$purchase->due_amount}} </p>
</div>  
@endsection