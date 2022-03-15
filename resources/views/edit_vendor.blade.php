@extends('layouts.admin')

@section('content')
<div class = "container">
    <h1 align="center">Edit Vendor</h1>

    <hr>
    @if(Auth::user()->is_admin == 1)

     {!! Form::open(['action' => ['DashboardController@update', $vendor->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}      {{-- <<UPDATE IS WHERE WE ARE SUBMITTNG TO>> --}}
        <div class="form-group">
            {{Form::label('vendor_name', 'Vendor Name')}}
            {{Form::text('vendor_name', $vendor->vendor_name, ['class' => 'form-control', 'placeholder' => 'Vendor Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('address', 'Address')}}
            {{Form::text('address', $vendor->address, ['class' => 'form-control', 'placeholder' => 'Address'])}}
        </div>
        {{-- <div class="form-group">
            {{Form::label('rate', 'Rate')}}
            {{Form::text('rate', $product->rate, ['class' => 'form-control', 'placeholder' => 'Rate'])}}
        </div> --}}
        {{-- <div class="form-group">
            {{Form::file('product_images')}}                //FOR IMAGE
        </div> --}}
        {{Form::hidden('_method', 'PUT')}}     {{-- spoof up put request >>ADD THIS LINE FOR EDIT<< --}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!} 
    @else
        <p>Only admin can access this page.</p>
    @endif
</div>   
@endsection