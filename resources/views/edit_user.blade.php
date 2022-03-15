@extends('layouts.admin')

@section('content')
<div class = "container">
    <h1 align="center">Edit User</h1>

    <hr>
    {{-- @if(Auth::user()->is_admin == 1) --}}

     {!! Form::open(['action' => ['DashboardController@update_user', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}      {{-- <<UPDATE IS WHERE WE ARE SUBMITTNG TO>> --}}
        <div class="form-group">
            {{Form::label('name', 'Name')}}
            {{Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'User Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'Email')}}
            {{Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => 'Email'])}}
        </div>
        {{-- <div class="form-group">
            {{Form::label('password', 'Password')}}
            {{Form::password('password', $user->password, ['class' => 'form-control', 'placeholder' => 'Password'])}}
        </div> --}}
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
    {{-- @else
        <p>Only admin can access this page.</p>
    @endif --}}
</div>   
@endsection