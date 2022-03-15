@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 align="center">Edit Purchase</h1>
    <hr>
    {!! Form::open(['action' => ['PurchasesController@update', $purchase[0]->pbill_id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}      {{-- <<UPDATE IS WHERE WE ARE SUBMITTNG TO>> --}}
        <div class="form-group d-none">
            {{Form::label('type', 'Transaction Type')}}
            {{Form::select('type', $type_list, ['class' => 'form-control', 'placeholder' => 'Trasaction Type'])}}
        </div>
        {{-- <div class = "form-group">
            {{Form::label('bill_number', 'Bill Number')}}
            {{Form::text('bill_number', $purchase[0]->pbill_id, ['class' => 'form-control'])}}          
        </div>    --}}
        <div class="form-group">
            {{Form::label('purchase_date', 'Date')}}
            {{Form::text('purchase_date', $purchase[0]->purchase_date, ['class' => 'form-control', 'placeholder' => 'Purchase Date'])}}
        </div>        
        <div class="form-group">
            {{Form::label('supplier', 'Supplier')}}
            {{Form::text('supplier', $purchase[0]->supplier, ['class' => 'form-control', 'placeholder' => 'Supplier'])}}
        </div>
        <div class="form-group">
            <table class = "table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Cost Price</th>
                        {{-- <th>Total Cost</th> --}}
                        <th>Sub</th> 
                        <th><a href="javascript:;" class="addRow"><i class="btn btn-info     glyphicon glyphicon-plus"><b>+</b></i></a></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchase as $purchases)

                    <tr>
                        <td><input type="hidden" name="purchase_id[]" value="{{$purchases->id}}"> 

                        {{Form::select('product[]', $product_list, $purchases->product_id, ['class' => 'form-control product', 'data-dependent' => 'rate'])}} </td>

                        <td><input type="number" name="stock[]" class="form-control stock" value="{{ $purchases->stock }}" required=""></td>

                        <td>{{Form::text('cost_price[]', $purchases->cost_price, ['class' => 'form-control cost_price'])}}</td>

                        {{-- <td><input type="text" name="total_cost[]" class="form-control total_cost" required=""></td> --}}

                        <td><b class="sub"></b></td>
                        
                        <td><a href="javascript:;" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"><b>x</b></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td style="border: none"></td>
                        <td style="border: none"></td>
                        <td>Total</td>
                        <td><b class="total"></b></td>
                        <td style="border: none"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="form-group">
            {{Form::label('total_cost', 'Total Cost')}}
            {{Form::text('total_cost', $purchase[0]->total_cost, ['class' => 'form-control', 'placeholder' => 'Total Cost'])}}
        </div>
        <div class="form-group">
            {{Form::label('paid_amount', 'Paid Amount')}}
            {{Form::text('paid_amount', $purchase[0]->paid_amount, ['class' => 'form-control', 'placeholder' => 'Paid Amount'])}}
        </div>
        <div class="form-group">
            {{Form::label('due_amount', 'Due Amount')}}
            {{Form::text('due_amount', $purchase[0]->due_amount, ['class' => 'form-control', 'placeholder' => 'Due Amount'])}}
        </div>
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
                
                $('tbody').delegate('.stock,.cost_price', 'keyup', function(){
                var tr= $(this).parent().parent();
                var stock=tr.find('.stock').val();
                var cost_price=tr.find('.cost_price').val();
    
                // var discount=tr.find('#discount').val();
    
                var sub=(stock*cost_price);
                tr.find('.sub').html(sub);
                total();
            });
    
            //Generate total sub amount and grand total
            function total(){
                var total = 0;
                // var discount = 0;
                var sub = 0;
                var total_cost = 0;
                $('.sub').each(function(i,e){
                    var sub=$(this).html()-0;
                    total += sub;
                });       
            $('.total').html(total+".00 NPR");
                
            // $('.cost_price').keyup(function(){
            //     var total = $(this).val();
            //     total = parseFloat($('.total').val());
            //     var result = (total);
            //     $('#total_cost').val(result.toFixed(2));
            // });
            
            //FOR GENERATING TOTAL COST
            var cost_price = $('.cost_price').val()?parseFloat($('.cost_price').val()):0; 
            var result = total;
            $('#total_cost').val(result.toFixed(2));
            
            //FOR GENERATING DUE AMOUNT
            var total_cost = parseFloat($('#total_cost').val());
            var paid_amount = $('#paid_amount').val()?parseFloat($('#paid_amount').val()):0;
            var result = total_cost - paid_amount;
            $('#due_amount').val(result.toFixed(2));
            }
    
            
            //Add Row
            $('.addRow').on('click', function(){
                addRow();
            });
            function addRow()
            {
                var tr='<tr>' +
                '<td><input type="hidden" name="purchase_id[]" value=""> {{Form::select('product[]', $product_list, null, ['class' => 'form-control product'])}} </td>' + //yesma value chai blank hunxa mathy chai hudaina
    
                '<td><input type="number" name="stock[]" class="form-control stock" required=""></td>' +
    
                '<td>{{Form::text('cost_price[]', '', ['class' => 'form-control cost_price'])}}</td>' +
    
                // '<td><input type="text" name="total_cost[]" class="form-control total_cost" required=""></td>' +
    
                '<td><b class="sub"></b></td>' +
    
                
                '<td><a href="javascript:;" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"><b>x</b></i></a></td>' +
                '</tr>';
                $('tbody').append(tr);
            };
    
            //Remove row
            $(document).on('click','.remove', function(){
                var last = $('tbody tr').length;
                if(last == 1)
                {
                    alert("Last row cannot be removed.");
                }
                else
                {
                    $(this).parent().parent().remove();
                }
            }); 
        
                // $('#cost_price').keyup(function(){
                //     var cost_price = $(this).val();
                //     var total_cost = $(this).val();
                //     cost_price = parseFloat($('#cost_price').val());
                //     stock = parseFloat($('#stock').val());
                //     var result = stock * cost_price;
                //     $('#total_cost').val(result.toFixed(2));
                // });
                
                $('.cost_price').keyup(function(){
                    total();
                });
    
                $('#paid_amount').keyup(function(){
                    // var total_cost = $(this).val();
                    // var paid_amount = $(this).val();
                    // total_cost = parseFloat($('#total_cost').val());
                    // paid_amount = parseFloat($('#paid_amount').val());
                    // var result = total_cost - paid_amount;
                    // $('#due_amount').val(result.toFixed(2));
                    total();
                });
    
                $( function() {
                    // $('#purchase_date').datepicker({
                    //     dateFormat: 'yy-mm-dd'
                    // });
                    $("#purchase_date").datepicker(({
                        dateFormat: 'yy-mm-dd'
                    })).datepicker("setDate", new Date());        
                });
            });
        </script>
@endsection