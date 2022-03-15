@extends('layouts.admin')

@section('content')
<div class = "container">
    <a href="/purchases" class='btn btn-info'><i class="far fa-hand-point-left"></i> Go Back</a>

    <h1 align="center">Products Bought from {{$purchase->supplier}}</h1>
    <hr>
    
    {{-- <p align="left"> <b> Sold to: </b> {{$order->client_name}} </p> <br>   --}}
    
        {{-- <p align="right"> <b> Date: {{$order->order_date}} </b> </p> <br> --}}
          
        <table class= "table table-responsive table-condensed table-hover table-striped table-bordered table-sm">
            <tr><b>
                <th>Bill Id</th>
                <th>Purchase Date</th>
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
                    <td>{{$purchase->purchase_date}}</td>
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
                                    {{-- {!!Form::open(['action' => ['PurchasesController@destroy', $purchase->id], 'method' => 'POST', 'class' => 'pull-right', 'style'=>"display:inline-block"])!!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                    {!!Form::close()!!}
                                    @else
                                    <p>Not Authorized</p>
                                @endif
                            @endif
                        </div>
                    </td> --}}
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
    --}}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){                   

        $('#rate').keyup(function(){
            var rate = $(this).val();
            var sale_quantity = $(this).val();
            rate = parseFloat($('#rate').val());
            sale_quantity = parseFloat($('#sale_quantity').val());
            var result = sale_quantity * rate;
            $('#sub_amount').val(result.toFixed(2));
        });

        $('#rate').keyup(function(){
            var sub_amount = $(this).val();
            sub_amount = parseFloat($('#sub_amount').val());
            var result = (sub_amount * 13) / 100;
            $('#vat').val(result.toFixed(2));
        });  
        
        $('#rate').keyup(function(){
            var sub_amount = $(this).val();
            var vat = $(this).val();
            sub_amount = parseFloat($('#sub_amount').val());
            vat = parseFloat($('#vat').val());
            var result = sub_amount + vat;
            $('#total_amount').val(result.toFixed(2));
        });     

        $('#discount').keyup(function(){
            var discount = $(this).val();
            var total_amount = $(this).val();
            total_amount = parseFloat($('#total_amount').val());
            discount = parseFloat($('#discount').val());
            var result = total_amount - discount;
            $('#grand_total').val(result.toFixed(2));
        });

        $('#paid_amount').keyup(function(){
            var grand_total = $(this).val();
            var paid_amount = $(this).val();
            grand_total = parseFloat($('#grand_total').val());
            paid_amount = parseFloat($('#paid_amount').val());
            var result = grand_total - paid_amount;
            $('#due_amount').val(result.toFixed(2));
        });
    });
</script>

@endsection