@extends('layouts.admin')

@section('content')
<link href="/js/print.css" rel="stylesheet" media="print" type="text/css">

<div class = "container">
    <a href="/orders" class='btn btn-default no-print'><i class="far fa-hand-point-left"></i> Go Back</a> <br>

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-12">

        <button onclick="myFunction()" class="float-right no-print" style="margin-right: 5px;"><i class="fa fa-print"></i> Print this page</button>

        {{-- <a href="" @click.prevent="printme" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
        <button type="button" class="btn btn-success float-right">
            <i class="fa fa-credit-card"></i>
            Submit Payment
        </button>

        <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
        <i class="fa fa-download"></i> Generate PDF
        </button> --}}
        
        </div>
    </div>

    <h1 align="center"><b>{{$vendor->vendor_name}}</b></h1>
    <h6 align="center">{{$vendor->address}}</h6>  
    <br>
    
    
    <p align="left">  
    <b> Bill Number: </b> {{$order->bill_id}} 
    <b class="float-right" style="margin-right: 5px;"> Date: {{$order->order_date}} </b>
    </p>
    <p align="left"> <b> Sold to: </b> {{$order->client_name}} </p> <br>

    {{-- this doesnot work below table --}}
    {{-- <b> Bill entered by: </b> {{$order->user->name}} --}} 


    <table class= "table table-responsive table-condensed table-hover table-striped table-bordered ">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Sub Amount</th>
            </tr>
        </thead>

        <tbody>
            @foreach($orders as $order)

            <tr>
                <td>{{$order->product_name}}</td>
                <td>{{$order->quantity}}</td>
                <td>{{$order->rate}}</td>
                <td>{{$order->sub_amount}}</td> 
                {{-- <td>{{$order->user->name}}</td> --}}
            </tr>

            @endforeach
        </tbody>

        {{-- @if (({{$order->discount}}) == 0) --}}
            
            <tfoot>
                <tr>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td><b>Discount</b></td>
                    <td><b>{{$order->discount}}</b></td>
                </tr>
                <tr>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td><b>Grand Total</b></td>
                    <td><b>{{$order->grand_total}}</b></td>
                </tr>
            </tfoot>

        {{-- @endif --}}

    </table>
    <br>          
        {{-- <table class= "table table-responsive table-condensed table-hover table-striped table-bordered">
            <tr><b>
                <th>Order Date</th>
                <th>Client Name</th>
                <th>Quantiy</th>
                <th>Rate</th>
                <th>Sub Amount</th>
                <th>Action</th>
            </b></tr>
            @foreach($orders as $order)
                <tr>
                    <td>{{$order->order_date}}</td>
                    <td>{{$order->client_name}}</td>
                    <td>{{$order->quantity}}</td>
                    <td>{{$order->rate}}</td>
                    <td>{{$order->sub_amount}}</td>
                    <td><a href="/orders/{{$order->id}}/edit" class="btn btn-default">Edit</a> --}}
                        {{-- For Delete --}}
                {{-- {!!Form::open(['action' => ['OrdersController@destroy', $order->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                    {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                {!!Form::close()!!}</td>                
                </tr>

            @endforeach
        </table>      --}}

    {{-- <p align="right"> <b> Discount : </b> {{$order->discount}} </p> --}}
    {{-- <p align="right"> <b> Grand Total : {{$order->grand_total}} </b></p> --}}

    <br>
    <p align="right" style="margin-right: 10px;"> <b> Paid Amount : </b> {{$order->paid_amount}} </p>
    <p align="right" style="margin-right: 10px;"> <b> Due Amount : </b> {{$order->due_amount}} </p> 
</div>

{{-- <script>
    $(document).ready(function(){   
        $('td').delegate('.sub_amount',function(){
            var tr= $(this).parent().parent();
            // var sale_quantity=tr.find('.sale_quantity').val();
            // var rate=tr.find('.rate').val();

            // var discount=tr.find('#discount').val();

            var sub_amount=tr.find('.sub_amount').val();
            tr.find('.sub_amount').val(sub_amount);
            total();
        });
           
        function total(){
            var total = 0;
            $('.sub_amount').each(function(i,e){
                    var sub_amount=$(this).val()-0;
                    total += sub_amount;
            });
        $('.total').html(total+".00 NPR");
        }
    };
</script> --}}


<script>
    function myFunction() {
        window.print();
    }
</script>
<style>
    @media print {
        body { font-size: 20pt }
        h1 { font-size: 40pt }
        h6 { font-size: 18pt }
    }
    /* @media screen {
        body { font-size: 20x }
    } 
    screen le chai view ma ni change garxa print le chai printing page ma matra change garxa
    @media screen, print {
        body { line-height: 2.0 }
    } */
    @media print {
        body { line-height: 2.0 }
    }
</style>
@endsection