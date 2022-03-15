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
</style>
<div class="container">
    <h1 align="center">My Purchases</h1>
    <hr>
    <a href="/purchases/create" class="btn btn-primary"><i class="fas fa-plus"></i> &nbsp;&nbsp;Add Purchase</a>
    <div class="three-inline-buttons" style="float: right;">
        <p> 
            <a href="/purchases/pay_up" class='one-third button btn bg-gradient-info' style="float: right;"><i class="fas fa-dollar-sign"></i>&nbsp;&nbsp;Payments</a>           
            <a href="/purchases/due" class='one-third button btn bg-gradient-teal' style="float: middle;"><i class="fas fa-hand-holding-usd"></i>&nbsp;  Due Amounts</a>

        </p>
    </div>

    <hr>
    @if(count($purchases) > 0)
    <div style="overflow-x:auto;">

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
                {{-- <th style="text-align:center">Written by</th> --}}
                <th style="text-align:center">Action</th>
            </tr>
            
            @foreach($purchases as $purchase)
                <tr style="text-align:center">

                    {{-- <td>{{$purchase->type}}</td> --}}
                    
                    <td><a href="/purchase_bill/{{$purchase->pbill_id}}">{{$purchase->pbill_id}}</a></td>
                    
                    
                    <td><a href="/purchase_date/{{$purchase->purchase_date}}">{{$purchase->purchase_date}}</a></td>
                                    
                    <td><a href="/supplier_report/{{$purchase->supplier}}">{{$purchase->supplier}}</a></td>
                    
                    <td>{{$purchase->product}}</td> 


                    <td>{{$purchase->stock}}</td>                   

                    <td>{{$purchase->cost_price}}</td>

                    <td>{{$purchase->total_cost}}</td>


                    <td>{{$purchase->paid_amount}}</td>

                    <td>{{$purchase->due_amount}}</td>

                    {{-- <td>{{$purchase->user->name}}</td> --}}

                    <td style='white-space: nowrap'>
                        <div class='row-fluid row mb-0'>
                            <div class="col-md-12 offset-md-0">
                            @if(!Auth::guest())
                                @if(Auth::user()->id == $purchase->user_id | Auth::user()->is_admin == 1)

                                    {{-- this edit button works but bill is not supposed to be edited so this button is diabled/commented --}}
                                    {{-- <a href="/purchases/{{$purchase->pbill_id}}/edit" class="btn btn-secondary" style="display:inline-block">Edit</a> --}}

                                
                                    <a href="/purchases/{{$purchase->pbill_id}}/payment" class="btn btn-info btn-sm"><i class="fas fa-dollar-sign"></i> Edit Payment</a>
                                
                                    {{-- For Delete --}}
                                    {!!Form::open([ 'class' => 'delete','action' => ['PurchasesController@destroy', $purchase->pbill_id], 'method' => 'POST', 'style' => 'display:inline-block'])!!}
                                        {{csrf_field()}}
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
        <br>{{$purchases->links()}} 
    @else
        <p>There are currently no purchases.</p>
    @endif    
</div>
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script>
        $(".delete").on("submit", function(){
            return confirm("Are you sure you wanna delete this record?");
        });
    </script>
@endsection