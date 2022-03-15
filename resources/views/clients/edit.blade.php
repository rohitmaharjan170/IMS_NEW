@extends('layouts.admin')

@section('content')
<div class = "container">
    <h1 align="center">Edit Client</h1>
    <hr>
     {!! Form::open(['action' => ['ClientsController@update', $client->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}      {{-- <<UPDATE IS WHERE WE ARE SUBMITTNG TO>> --}}
        <div class="form-group">
            {{Form::label('client_name', 'Client Name')}}
            {{Form::text('client_name', $client->client_name, ['class' => 'form-control', 'placeholder' => 'Client Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('client_address', 'Client Address')}}
            {{Form::text('client_address', $client->client_address, ['class' => 'form-control', 'placeholder' => 'Address'])}}
        </div>
        <div class="form-group">
            {{Form::label('client_contact', 'Client Contact')}}
            {{Form::text('client_contact', $client->client_contact, ['class' => 'form-control', 'placeholder' => 'Contact Number'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'Email')}}
            {{Form::text('email', $client->email, ['class' => 'form-control', 'placeholder' => 'Email'])}}
        </div>

        <div class="form-group">
            <table class = "table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>                        
                        <th>Rate</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rate as $r)

                    <tr>
                                    
                        <td>

                            <input type="hidden" name="id[]" value="{{$r->id}}">   
                            <input type="hidden" name="product_id[]" value="{{$r->product_id}}">   
                            
                            {{Form::text('product_name[]', $r->name, ['readonly' => 'readonly', 'class' => 'form-control product_name'])}}
                        
                        </td>     

                        <td>{{Form::text('client_rate[]',  $r->client_rate, ['class' => 'form-control client_rate'])}}</td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{Form::hidden('_method', 'PUT')}}     {{-- spoof up put request >>ADD THIS LINE FOR EDIT<< --}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}   
</div> 
@endsection