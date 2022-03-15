@extends('layouts.admin')

@section('content')
<div class = "container">
<h1 align = "center">Add Vendor</h1>
<hr>
{!! Form::open(['action' => 'DashboardController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!} {{-- <<STORE IS WHERE WE ARE SUBMITTNG TO>> --}}
    <div class="form-group">
        {{Form::label('vendor_name', 'Vendor Name')}}
        {{Form::text('vendor_name', '', ['class' => 'form-control', 'placeholder' => 'Vendor Name'])}}
    </div>
    <div class="form-group">
        {{Form::label('address', 'Address')}}
        {{Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Address'])}}
    </div>
    {{-- <div class="form-group">
        {{Form::label('user_id', 'User')}}
        {{Form::text('user_id', '', ['class' => 'form-control', 'placeholder' => 'User'])}}
    </div> --}}
    {{-- <div class="form-group">
        {{Form::file('product_image')}}          //UPLOADING IMAGE
    </div> --}}
    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
{!! Form::close() !!}
</div>
@endsection