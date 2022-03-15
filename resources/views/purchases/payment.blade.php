@extends('layouts.admin')

@section('content')
<div class = "container">
    <h1 align="center">Edit Payment</h1>
    <hr>
     {!! Form::open(['action' => ['PurchasesController@addPayment', $purchase[0]->pbill_id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}      {{-- <<UPDATE IS WHERE WE ARE SUBMITTNG TO>> --}}
        <div class = "form-group">
            {{Form::label('payment_date', 'Date')}}
            {{Form::text('payment_date', '', ['class' => 'form-control'])}}
        </div>  

        <div class = "form-group">
            {{Form::label('pbill_id', 'Bill Id')}}
            {{Form::text('pbill_id', $purchase[0]->pbill_id, ['class' => 'form-control', 'readonly' => 'readonly'])}}
        </div>
        
        <div class = "form-group">
            {{Form::label('grand_total', 'Grand Total')}}
            {{Form::text('grand_total', $purchase[0]->total_cost, ['class' => 'form-control', 'readonly' => 'readonly'])}}
        </div>
        
        <div class = "form-group">
            {{Form::label('due_amount', 'Due Amount')}}
            {{Form::text('due_amount', $pbill->due_amount, ['class' => 'form-control', 'readonly' => 'readonly'])}}
        </div>
        
        <div class = "form-group">
            {{Form::label('paid_amount', 'Pay Amount')}}
            {{Form::text('paid_amount', '', ['class' => 'form-control'])}}
        </div>
        <?php 
            // dd($payment);
        ?>
        {{Form::hidden('_method', 'PUT')}}     {{-- spoof up put request >>ADD THIS LINE FOR EDIT<< --}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}  

</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    
    {{-- FOR DATE PICKER --}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    

     
    <script>
        $(document).ready(function(){              

            // $('#paid_amount').keyup(function(){
            //     var currentValue = $(this).val();  
            //     var newValue = $('');
            //     currentValue = parseFloat($('#paid_amount').val());
            //     var result = currentValue + newValue;
            //     $('#paid_amount').val(result);
            // }

            // $('#due_amount').keyup(function(){
            //     var currentValue = $(this).val();  
            //     var newValue = $('');
            //     currentValue = parseFloat($('#due_amount').val());
            //     var result = currentValue - newValue;
            //     $('#due_amount').val(result);
            // }

                // following datepicker code stopped working suddenly
            // $( function() {
            //     // $('#purchase_date').datepicker({
            //     //     dateFormat: 'yy-mm-dd'
            //     // });
            //     $("#payment_date").datepicker(({
            //         dateFormat: 'yy-mm-dd'
            //     })).datepicker("setDate", new Date());        
            // });  
        });
    </script>
    <script>
        jQuery(document).ready(function($) {
            $('#payment_date').datepicker({
                dateFormat: "yy-mm-dd"
            }).datepicker("setDate", new Date());
        });
    </script>
    

@endsection