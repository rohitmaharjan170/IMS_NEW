@extends('layouts.admin')

@section('content')
<div class = "container">
    <h1 align="center">Add Products</h1>
    <hr>
    {!! Form::open(['action' => 'ProductsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!} {{-- <<STORE IS WHERE WE ARE SUBMITTNG TO>> --}}
        <div class="form-group">
            {{Form::label('name', 'Product Name')}}
            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Product Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('quantity', 'Quantity')}}
            {{Form::text('quantity', '', ['class' => 'form-control', 'placeholder' => 'Quantity'])}}
        </div>
        <div class="form-group">
            {{Form::label('rate', 'Rate')}}
            {{Form::text('rate', '', ['class' => 'form-control', 'placeholder' => 'Rate'])}}
        </div>
        {{-- <div class="form-group">
            {{Form::file('product_image')}}          //UPLOADING IMAGE
        </div> --}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!} 
</div>
@endsection