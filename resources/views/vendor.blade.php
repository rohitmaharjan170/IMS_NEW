@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 align="center">Vendor Details</h1>
    <hr>    
    {!! Form::open() !!}
    @foreach($vendor as $vendors)
        {{-- @if(Auth::user()->id !== $vendors->user_id)
            <a href="create" class = "btn btn-primary">Add Vendor</a>
            <hr> 
        @endif --}}
    
        
        @if(Auth::user()->id == $vendors->user_id | Auth::user()->is_admin == 1)
            <div class="data data-status">
                {{Form::label('vendor_name', 'Vendor Name :')}}
                {{Form::label('vendor_name', $vendors->vendor_name)}}
            </div>
            <div class="form-group">
                {{Form::label('address', 'Address :')}}
                {{Form::label('address', $vendors->address)}}
            <br>
                {{Form::label('user_name', 'User Name : ')}}
                {{Form::label('user_name', $vendors->user->name)}}
            </div>

            @if(Auth::user()->is_admin == 1)
            <a href="{{$vendors->id}}/edit_vendor" class="btn btn-secondary" style="display:inline-block"><i class="fas fa-edit"></i>  Change Vendor Details</a>
            @endif
            
            <hr>
            {{-- {!!Form::open(['class'=>'delete', 'action' => ['DashboardController@destroy', $vendors->id], 'method' => 'POST', 'style' => 'display:inline-block'])!!}

            
                {{Form::hidden('_method', 'DELETE')}}
                

                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!} --}}            
            

            {{-- <form action="{{route('setting.destroy',[$vendors->id])}}" method="POST">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>               
               </form>
            <hr> --}}
        
            
        @endif
        {{-- @if($users->user_id == Auth::user()->id)
            <a href="create" class = "btn btn-primary">Add Vendor</a>
            <hr> 
        @endif --}}
    @endforeach
    @if($user == true)
    
    @else
        <a href="create" class = "btn btn-primary"><i class="fas fa-plus"></i> &nbsp;&nbsp;Add Vendor</a>
        <hr> 
    @endif
    {!! Form::close() !!}       
</div>
@endsection