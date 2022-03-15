@extends('layouts.admin')

@section('content')
<div class = "container">
    <h1 align="center">Edit Product</h1>
    <hr>
     {!! Form::open(['action' => ['ProductsController@update', $product->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}      {{-- <<UPDATE IS WHERE WE ARE SUBMITTNG TO>> --}}
        <div class="form-group">
            {{Form::label('name', 'Product Name')}}
            {{Form::text('name', $product->name, ['class' => 'form-control', 'placeholder' => 'Product Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('quantity', 'Quantity')}}
            {{Form::text('quantity', $product->quantity, ['class' => 'form-control', 'placeholder' => 'Quantity'])}}
        </div>
        <div class="form-group">
            {{Form::label('rate', 'Rate')}}
            {{Form::text('rate', $product->rate, ['class' => 'form-control', 'placeholder' => 'Rate'])}}
        </div>
        {{-- <div class="form-group">
            {{Form::file('product_images')}}                //FOR IMAGE
        </div> --}}
        {{Form::hidden('_method', 'PUT')}}     {{-- spoof up put request >>ADD THIS LINE FOR EDIT<< --}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!} 
</div>   
@endsection