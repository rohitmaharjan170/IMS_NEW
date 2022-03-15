@extends('layouts.admin')

@section('content')
    <div class = "container">
        <h1 align="center">User Details</h1> <hr>
        <div class="data data-status">
            {{Form::label('name', 'Name :')}}
            {{Form::label('name', $user->name)}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'E-mail :')}}
            {{Form::label('email', $user->email)}}
        <br>
            {{Form::label('is_admin', 'Is Admin : ')}}
            @if (Auth::user()->is_admin == 1)
            {{Form::label('user_name', 'Yes')}}
            @else
            {{Form::label('user_name', 'No')}}

            @endif
        </div>
        @if(Auth::user()->is_admin == 1)
            <a href="/{{$user->id}}/edit_user" class="btn btn-secondary" style="display:inline-block"><i class="fas fa-edit"></i>  Change User Details</a>
        @endif
    </div>
@endsection