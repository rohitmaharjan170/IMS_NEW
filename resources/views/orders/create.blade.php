@extends('layouts.admin')

@section('content')
<div class="container">
<h1 align="center">Add Order</h1>
<hr>
    {!! Form::open(['action' => 'OrdersController@store', 'method' => 'POST']) !!}
        {{ csrf_field() }}
        <div class="form-group">
            {{-- <div class = "form-group">
                {{Form::label('bill_number', 'Bill Number')}}
                {{Form::text('bill_number', '', ['class' => 'form-control'])}}                
            </div>         --}}
            <div class = "form-group d-none">
                {{Form::label('type', 'Transaction Type')}}
                {{Form::select('type', $type_list, null, ['class' => 'form-control dynamic'])}}   
            </div>
            <div class = "form-group">
                {{Form::label('order_date', 'Order Date')}}
                {{Form::text('order_date', '', ['class' => 'form-control'])}}                         
            </div>
            <div class = "form-group col-lg">
                {{Form::label('client_name', 'Client Name')}}
                
                {{-- <input type="hidden" name="client_id" value="{{$client_list->id}}">  --}}
                {{Form::select('client_name', $client_list, null, ['class' => 'form-control client_name'])}}
                {{-- {{Form::hidden('client_id', $client_id, ['class' => 'form-control'])}} --}}

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
                            <th><a href="javascript:;" class="addRow"><i class="btn btn-info glyphicon glyphicon-plus"><b>+</b></i></a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{Form::select('product_name[]', $product_list, null, ['class' => 'form-control product_name', 'id' =>'product_name', 'data-dependent' => 'rate sale_quantity'])}} 
                            </td>

                            <td><input type="number" id="sale_quantity" name="sale_quantity[]" class="form-control sale_quantity" required=""></td>

                            <td>{{Form::text('rate[]', '', ['readonly'=>'readonly', 'class' => 'form-control rate'])}}</td>

                            <td><input readonly="readonly" name="sub_amount[]" class="form-control sub_amount" required=""></td>
                            
                            <td><a href="javascript:;" class="btn btn-danger remove"><b class="glyphicon glyphicon-remove">x</b></a></td>
                        </tr>
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
                {{Form::text('discount', '', ['class' => 'form-control'])}}
            </div>
            <div class = "form-group">
                {{Form::label('grand_total', 'Grand Total')}}
                {{Form::text('grand_total', '', ['class' => 'form-control'])}}
            </div>
            <div class = "form-group">
                {{Form::label('paid_amount', 'Paid Amount')}}
                {{Form::text('paid_amount', '', ['class' => 'form-control'])}}
            </div>
            <div class = "form-group">
                {{Form::label('due_amount', 'Due Amount')}}
                {{Form::text('due_amount', '', ['class' => 'form-control'])}}
            </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        </div>
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
        
        // var product = $('.product_name');
        // var fix = "selected";
        // $('.product_name').change(function() {
        //     product.val(fix); 
        //     product.prop('disabled', true);
        // });

        //Generate product rate based on client from rate table

        $(document).on('change','.client_name',function(){
            $('.client_name').change(function() {$('.product_name').val('0')}); //reset product name
            $('.client_name').change(function() {$('.sale_quantity').val('')}); //reset product name

            $(document).on('change','.product_name',function(){ //dynamic change xa vane use this
                // $('.product_name').change(function(){    // one time matra use garera paxi nachaye yo use garni
                // alert("here");
                // $('.rate').val('');

                // $('.product_name').change(function() {$('.sale_quantity').val('')}); //reset quantity
                var parenttr = $(this).parent('td').parent('tr'); //selector

                // console.log(parenttr.find('input.rate').val());
                // var client_id = $('#client_id').val();
                var id = $(this).val(); //this is product_id

                var client_id = $("#client_name").val(); //this is client_id
                
                var _token = $('input[name="_token"]').val();
                
                $.ajax({
                    url:"{{ url('findRate') }}",
                    method:"POST",
                    data:{id:id, _token:_token, client_id:client_id},
                    success:function(result)
                    {
                        parenttr.find('input.rate').val(result);
                    }
                })
                // parenttr.find('input.sale_quantity').val(0);
                // $.ajax({
                //     url:"{{ url('findQuantity') }}",
                //     method:"POST",
                //     data:{id:id, _token:_token},
                //     success:function(result)
                //     {
                //         // alert(result);
                //         $('.sale_quantity').on('input', function () {
                //             // $('.product_name').change(function() {
                //             var value = parenttr.find('input.sale_quantity').val();
                //             parenttr.find('input.sale_quantity').val(Math.max(Math.min(value, result), 1));
                //             // });                               
                //         });
                //     }
                // })

            });
        });   

        $(document).on('input','.sale_quantity',function(){ //dynamic change xa vane use this
                
                var parenttr = $(this).parent('td').parent('tr'); //selector
                
                var id = parenttr.find('select.product_name').val();; //this is product_id
                
                var _token = $('input[name="_token"]').val(); //post request pathauna chaixa i.e., method:"POST"
                
                // parenttr.find('input.sale_quantity').val(0);
                $.ajax({
                    url:"{{ url('findQuantity') }}",
                    method:"POST",
                    data:{id:id, _token:_token},
                    success:function(result)
                    {
                        // alert(result);
                        // $('.sale_quantity').on('input', function () {
                            // $('.product_name').change(function() {
                            var value = parenttr.find('input.sale_quantity').val();
                            parenttr.find('input.sale_quantity').val(Math.max(Math.min(value, result), 0));
                            // });                               
                        // });
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

        $('.total').html(total+".00 NPR");

            var discount = $('#discount').val()?parseFloat($('#discount').val()):0; //takes value of discount if no then it takes 0
            var result = total - discount;
            $('#grand_total').val(result.toFixed(2));

            var grand_total = parseFloat($('#grand_total').val());
            var paid_amount = $('#paid_amount').val()?parseFloat($('#paid_amount').val()):0;
            var result = grand_total - paid_amount;
            $('#due_amount').val(result.toFixed(2));
        }
        
        //Add Row
        $('.addRow').on('click', function(){
            addRow();
        });
        function addRow()
        {
            var tr='<tr>' +
            '<td>{{Form::select('product_name[]', $product_list, null, ['id' => 'product_name', 'class' => 'form-control product_name', 'data-dependent' => 'rate'])}} </td>'+
            '<td><input type="number" id="sale_quantity" name="sale_quantity[]" class="form-control sale_quantity" required=""></td>'+
            '<td>{{Form::text('rate[]', '', ['readonly'=>'readonly', 'class' => 'form-control rate'])}}</td>' +
            '<td><input readonly="readonly" type="text" name="sub_amount[]" class="form-control sub_amount" required=""></td>'+
            '<td><a href="javascript:;" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"><b>x</b></i></a></td>' +
            '</tr>';
            $('tbody').append(tr);

            // var product_name = $('.product_name');
            // $('.product_name').on('change', function(e) {
            //     $("#product_name option:selected").attr('name');
            //     // product_name.val('selected'); // sets the value
            //     product_name.attr('disabled', true); //disables the select
            // });
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

        // //disables dropdown after selecting product
        // var product_name = $('#product_name');
        // $('.product_name').on('change', function(e) {
        //     $(".product_name option:selected").attr('name');
        //     // product_name.val('selected'); // sets the value
        //     product_name.attr('disabled', true); //disables the select
        // });

        // uncomment from...
        // //Generate product quantity (this works)
        //     // $('.product_name').change(function(){

        // $(document).on('change','.product_name',function(){
        //     // $('.product_name').change(function() {$(".sale_quantity").reset();}); //reset quantity
        //     // $(document).on('change','.product_name',function(){
        //     //         $(".sale_quantity")[0].clear();
        //     //     });

        //     // $('.sale_quantity').val('');
        //     var parenttr = $(this).parent('td').parent('tr'); //selector


        //     var id = $(this).val();
        //     var _token = $('input[name="_token"]').val();
        //     $.ajax({
        //         url:"{{ url('findQuantity') }}",
        //         method:"POST",
        //         data:{id:id, _token:_token},
        //         success:function(result)
        //         {
        //             alert((result));
        //             // $('.sale_quantity').val(result);
        //             // array.forEach(function(addRow) => {
        //                 // $('.sale_quantity').bind(function(){
        //                     // $.each(('.sale_quantity'), function( addRow, result ) {
        //                     // $('.sale_quantity').on('input', function () {
        
        //                     //     // var value = $(this).val();
        //                     //     var value = parenttr.find('input.sale_quantity').val();

                                
        //                     //     // if ((value !== '') && (value.indexOf('.') === -1)) {
        //                     //     // if ($('.input').attr('value') == ''){
        //                     //         $(this).val(Math.max(Math.min(value, result), 0));
        //                     //     // }
        //                     //     // }
        //                     // });
        //                     // $('.product_name').each(function() {

        //                     $('.sale_quantity').on('input', function () {
        //                         var value = parenttr.find('input.sale_quantity').val();

                                
        //                         parenttr.find('input.sale_quantity').val(Math.max(Math.min(value, result), 1));
                                
                                
        //                     });
        //                     // });

        //                     // });
        //                 // });
                        
        //             // });
        //         }
        //     })            
        // }); 
        // // });
        // ..to uncomment
        
        //Date Picker
        // $( function() {
        //     // $('#purchase_date').datepicker({
        //     //     dateFormat: 'yy-mm-dd'
        //     // });
        //     $("#order_date").datepicker(({
        //         dateFormat: 'yy-mm-dd'
        //     })).datepicker("setDate", new Date());        
        // });        

        
        
        $('#discount').keyup(function(){
            total(); //calling function total
        });

        $('#paid_amount').keyup(function(){
           total();
        });       
    });

    jQuery(document).ready(function($) {
        $('#order_date').datepicker({
            dateFormat: "yy-mm-dd"
        }).datepicker("setDate", new Date());
    });
</script>

@endsection

{{-- //UNUSED from inside script tag
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
        // }); --}}