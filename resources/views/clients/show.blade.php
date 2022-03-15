@extends('layouts.admin')

@section('content')
<div class = "container">
    <a href="/clients" class='btn btn-default' style="display:inline-block"><i class="far fa-hand-point-left"></i> Go Back</a>
    
    
    <br><br>
    <h1>{{$client->client_name}}</h1>
    <div class="form-group">
    Address: {{$client->client_address}} <br>
    Contact Number: {{$client->client_contact}} <br>
    <p>Email: @if ($client->email == '')
                No email</p>
            @else
                {{$client->email}}
            @endif
    {{-- Ordered Products: {{$order->product_name}} --}}
    </div>
    <br>
    <h4><b>Product Rates for {{ $client->client_name }} </b></h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                {{-- <th>Client Id</th> --}}
                <th>Product</th>
                <th>Rate</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr>                
                <td>{{$client->name}}</td>
                <td>{{$client->client_rate}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{-- <small>Added on {{$client->created_at}} by {{$client->user->name}}</small> --}}

    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $client->user_id  | Auth::user()->is_admin == 1)
            <a href="/clients/{{$client->id}}/edit" style="display:inline-block" class="btn btn-secondary"><i class="fas fa-edit"></i> Edit</a>
                    {{-- For Delete --}}
            {!!Form::open(['action' => ['ClientsController@destroy', $client->id], 'method' => 'POST', 'class' => 'delete pull-right', 'style'=>'display:inline-block'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                    {{-- {{Form::submit('Delete', ['class' => 'btn btn-danger'])}} --}}
                    <button class="delete btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
            {!!Form::close()!!}
            <a href="/client_order/{{$client->client_name}}" class='btn btn-info'><i class="fas fa-file-alt"></i>  {{$client->client_name}}'s order reports</a>
        @endif
    @endif
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script>
        $(".delete").on("submit", function(){
            return confirm("Are you sure you wanna delete this?");
        });
    </script>
@endsection