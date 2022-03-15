@extends('layouts.admin')

@section('content')
<div class="container">
<h1 align="center">Edit Order</h1>
<hr>

    {!! Form::open(['action' => ['OrdersController@update', $order[0]->bill_id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        {{ csrf_field() }}
        <div class="form-group">
            {{-- <div class = "form-group">
                {{Form::label('bill_number', 'Bill Number')}}
                {{Form::text('bill_number', $order[0]->bill_id, ['class' => 'form-control'])}}
            </div>         --}}
            {{-- [0] -> this takes any one field from the array --}}
            <div class = "form-group d-none">
                {{Form::label('type', 'Transaction Type')}}
                {{Form::select('type', $type_list, $order[0]->type_id, ['class' => 'form-control dynamic'])}}   
            </div>
            <div class = "form-group">
                {{Form::label('order_date', 'Order Date')}}
                {{Form::text('order_date', $order[0]->order_date, ['class' => 'form-control'])}}                         
            </div>
            <div class = "form-group col-lg">
                {{Form::label('client_name', 'Client Name')}}
                {{Form::select('client_name', $client_list, $order[0]->client_id, ['class' => 'form-control'])}}
            </div>
            <br>
            
            <div class="form-group">
                <table class = "table table-bordered">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Sub Amount</th>
                            <th><a href="javascript:;" class="addRow"><i class="btn btn-info     glyphicon glyphicon-plus"><b>+</b></i></a></th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach ($order as $orders)
                            <tr>
                                <td>
                                    <input type="hidden" name="order_id[]" value="{{$orders->id}}">   

                                    {{Form::text('product_name[]', $product_list, $orders->product_id, ['class' => 'form-control product_name', 'data-dependent' => 'rate'])}}
                                </td>

                                <td><input readonly="readonly" name="sale_quantity[]" class="form-control sale_quantity" value="{{ $orders->quantity }}" required=""></td>

                                <td>{{Form::text('rate[]', $orders->rate, ['class' => 'form-control rate'])}}</td>

                                <td><input type="text" name="sub_amount[]" class="form-control sub_amount" value="{{ $orders->sub_amount }}" required=""></td>
                                
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
            <div class = "form-group">
                {{Form::label('discount', 'Discount')}}
                {{Form::text('discount', $order[0]->discount, ['class' => 'form-control'])}}
            </div>
            <div class = "form-group">
                {{Form::label('grand_total', 'Grand Total')}}
                {{Form::text('grand_total', $order[0]->grand_total, ['class' => 'form-control'])}}
            </div>
            <div class = "form-group">
                {{Form::label('paid_amount', 'Paid Amount')}}
                {{Form::text('paid_amount', $order[0]->paid_amount, ['class' => 'form-control'])}}
            </div>
            <div class = "form-group">
                {{Form::label('due_amount', 'Due Amount')}}
                {{Form::text('due_amount', $order[0]->due_amount, ['class' => 'form-control'])}}
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

{{-- FOR MULTIPLE DATA ENTRY --}}
{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js">
</script> --}}


{{-- <script src="./js/rate.js"></script> --}}

{{-- <script>
    $("#product_name").on('change', function() {
        alert($(this).val());
        if ($(this).val() == 'option2') {
            var sid = $(this).parent().parent().children()[3];
            var data = $(this).attr("data_val");
            var sid_value = $(sid).children()[0].value;
            window.location = 'new.php?data=' + data + '&sid=' +   sid_value;
        }});
</script> --}}

<script type="text/javascript">
    $(document).ready(function(){  
        
        // $('.dynamic').change(function(){
        //     if($(this).val() != '')
        //     {
        //         var select = $(this).attr("id");
        //         var value = $(this).val();
        //         var dependent = $(this).data('dependent');
        //         var _token = $('input[name="_token"]').val();
        //         $.ajax({
        //             url:"{{ route('orderscontroller.fetch') }}",                    
        //             method:"POST",
        //             data:{select:select, value:value, _token:_token, dependent:dependent},
        //             success:function(result)
        //             {
        //                 $('#'+dependent).html(result);
        //             }                
        //         })
        //     }
        // });
        
        //Generate product rate
        $(document).on('change','.product_name',function(){ //dynamic change xa vane use this
        // $('.product_name').change(function(){    // one time matra use garera paxi nachaye yo use garni
            // alert("here");
            // $('.rate').val('');
            var parenttr = $(this).parent('td').parent('tr'); //selector
            // console.log(parenttr.find('input.rate').val());
            var id = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{ url('findRate') }}",
                method:"POST",
                data:{id:id, _token:_token},
                success:function(result)
                {
                    parenttr.find('input.rate').val(result);
                }
            })            
        });

        //Generate product quantity
        $('#product_name').change(function(){
            $('#sale_quantity').val('');
            var id = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{ url('findQuantity') }}",
                method:"POST",
                data:{id:id, _token:_token},
                success:function(result)
                {
                     $('#sale_quantity').val(result);
                }
            })            
        });        

        $('tbody').delegate('.sale_quantity,.rate', 'keyup', function(){
            var tr= $(this).parent().parent();
            var sale_quantity=tr.find('.sale_quantity').val();
            var rate=tr.find('.rate').val();

            var discount=tr.find('#discount').val();

            var sub_amount=(sale_quantity*rate);
            tr.find('.sub_amount').val(sub_amount);
            total();
        });

        //Generate total sub amount and grand total
        function total(){
            var total = 0;
            var discount = 0;
            var grand_total = 0;
            $('.sub_amount').each(function(i,e){
                    var sub_amount=$(this).val()-0;
                    total += sub_amount;
            });
            $('#discount').keyup(function(){
                var discount = $(this).val();
                discount = parseFloat($('#discount').val());
                var result = total - discount;
            $('#grand_total').val(result.toFixed(2));
        });
        $('.total').html(total+".00 NPR");
        }
        
        //Add Row
        $('.addRow').on('click', function(){
            addRow();
        });
        function addRow()
        {
            var tr='<tr>' +
            
            '<td> <input type="hidden" name="order_id[]" value=""> {{Form::select('product_name[]', $product_list, null, ['class' => 'form-control product_name', 'data-dependent' => 'rate'])}} </td>'+ //yesma value blank hunxa mathi hudaina
            '<td><input type="text" name="sale_quantity[]" class="form-control sale_quantity" required=""></td>'+
            '<td>{{Form::text('rate[]', '', ['class' => 'form-control rate'])}}</td>' +
            '<td><input type="text" name="sub_amount[]" class="form-control sub_amount" required=""></td>'+
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
        
        //Date Picker
        $( function() {
            // $('#purchase_date').datepicker({
            //     dateFormat: 'yy-mm-dd'
            // });
            $("#order_date").datepicker(({
                dateFormat: 'yy-mm-dd'
            })).datepicker("setDate", new Date());        
        });        

        //UNUSED
        // $('#rate').keyup(function(){
        //     var sub_amount = $(this).val();
        //     sub_amount = parseFloat($('#sub_amount').val());
        //     var result = (sub_amount * 13) / 100;
        // });          
        //     $('#vat').val(result.toFixed(2));
        // $('#rate').keyup(function(){
        //     var sub_amount = $(this).val();
        //     var vat = $(this).val();
        //     sub_amount = parseFloat($('#sub_amount').val());
        //     vat = parseFloat($('#vat').val());
        //     var result = sub_amount + vat;
        //     $('#total_amount').val(result.toFixed(2));
        // });     


        // UNUSED AFTER MULTITPLE INSERT

        // $('#rate').keyup(function(){
        //     var rate = $(this).val();
        //     var sale_quantity = $(this).val();
        //     rate = parseFloat($('#rate').val());
        //     sale_quantity = parseFloat($('#sale_quantity').val());
        //     var result = sale_quantity * rate;
        //     $('#sub_amount').val(result.toFixed(2));
        // });
        
        // $('#discount').keyup(function(){
        //     var discount = $(this).val();
        //     var sub_amount = $(this).val();
        //     sub_amount = parseFloat($('#sub_amount').val());
        //     discount = parseFloat($('#discount').val());
        //     var result = sub_amount - discount;
        //     $('#grand_total').val(result.toFixed(2));
        // });

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
    

{{-- <script>
$(document).ready(function(){

    $('.dynamic').change(function(){
        if($(this).val() != '')
        {
            var select = $(this).attr("id");
            var value = $(this).val();
            var dependent = $(this).data('dependent');
            var _token = $('input[name = "token"]').val();
            $.ajax({
                url:"{{ route('dynamicdependent.fetch') }}",
                method:"POST",
                data:{select:select, value:value, _token:_token, dependent:dependent},
                sucess:function(result)
                {
                    $('#'+dependent). html(result);
                }
            })
        }
    }
});
</script> --}}


