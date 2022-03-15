@extends('layouts.admin')

@section('content')
<div class = "container">
    <h1 align="center">Add Stock</h1>
    <hr>
     {!! Form::open(['action' => ['ProductsController@addStock', $stock->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}      {{-- <<UPDATE IS WHERE WE ARE SUBMITTNG TO>> --}}
        
        <div class="form-group">
            {{Form::label('quantity', 'Quantity')}}
            {{Form::number('quantity', $stock->stock, ['class' => 'form-control'])}}
        </div>
        
        {{Form::hidden('_method', 'PUT')}}     {{-- spoof up put request >>ADD THIS LINE FOR EDIT<< --}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}  

</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

     
    <script>
        $(document).ready(function(){
            $('#quantity').keyup(function(){
                var currentValue = $(this).val();  
                var newValue = $('');
                currentValue = parseInt($('#quantity').val());
                var result = currentValue + newValue;
                $('#quantity').val(result);
            }
        });
    </script>

@endsection