@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 align="center">Add Client</h1>
    {!! Form::open(['action' => 'ClientsController@store', 'method' => 'POST']) !!}
    {{ csrf_field() }}

        <div class = "form-group">
            {{Form::label('client_name', 'Client Name')}}
            {{Form::text('client_name', '', ['class' => 'form-control', 'placeholder' => 'Client Name'])}}
        </div>
        <div class = "form-group">
            {{Form::label('client_address', 'Client Address')}}
            {{Form::text('client_address', '', ['class' => 'form-control', 'placeholder' => 'Client Address'])}}
        </div>
        <div class = "form-group">
            {{Form::label('client_contact', 'Client Contact')}}
            {{Form::text('client_contact', '', ['class' => 'form-control', 'placeholder' => 'Client Contact'])}}
        </div>
        <div class = "form-group">
            {{Form::label('email', 'Email')}}
            {{Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'Email'])}}
        </div>

        <div class="form-group">
            <table class = "table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>                        
                        <th>Rate</th>
                        {{-- <th><a href="javascript:;" class="addRow"><i class="btn btn-info glyphicon glyphicon-plus"><b>+</b></i></a></th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product_list as $product_lists)
                    <tr>
                        {{-- <td>{{Form::select('product_id[]', $product_list, null, ['class' => 'form-control product_id', 'data-dependent' => 'rate'])}} </td>                   --}}
                        
                        <td>
                            <input type="hidden" name="product_id[]" value="{{$product_lists->id}}"> 
                            
                            {{Form::text('product_name[]', $product_lists->name, ['readonly' => 'readonly', 'class' => 'form-control product_name'])}}
                        
                        </td>     

                        <td>{{Form::text('client_rate[]',  $product_lists->rate, ['class' => 'form-control client_rate'])}}</td>

                        
                        {{-- <td><a href="javascript:;" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"><b>x</b></i></a></td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<script type="text/javascript">
    $(document).ready(function(){  
              
        //Generate product rate
        $(document).on('change','.product_id',function(){ //dynamic change xa vane use this
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
                    parenttr.find('input.client_rate').val(result);
                }
            })            
        });

        // //Add Row
        // $('.addRow').on('click', function(){
        //     addRow();
        // });
        // function addRow()
        // {
        //     var tr='<tr>' +
        //     '<td>{{Form::select('product_id[]', $product_list, null, ['class' => 'form-control product_id', 'data-dependent' => 'rate'])}} </td>'+
            
        //     '<td>{{Form::text('client_rate[]', '', ['class' => 'form-control client_rate'])}}</td>' +
            
        //     '<td><a href="javascript:;" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"><b>x</b></i></a></td>' +
        //     '</tr>';
        //     $('tbody').append(tr);
        // };

        // //Remove row
        // $(document).on('click','.remove', function(){
        //     var last = $('tbody tr').length;
        //     if(last == 1)
        //     {
        //         alert("Last row cannot be removed.");
        //     }
        //     else
        //     {
        //         $(this).parent().parent().remove();
        //     }
        // });       
    });
</script>
@endsection