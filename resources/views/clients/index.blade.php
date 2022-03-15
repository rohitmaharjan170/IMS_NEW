@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 align="center">Clients</h1>
    <hr>
    <a href="/clients/create" class='btn btn-primary'><i class="fas fa-plus"></i> &nbsp;&nbsp;Add Client</a>
    <hr>
    @if(count($clients) > 0)
    <div style="overflow-x:auto;">
        <table class= "table table-responsive table-condensed table-hover table-striped table-bordered table-sm">
            <tr>
                <th style="text-align:center">Client Name</th>
                <th style="text-align:center">Client Address</th>
                <th style="text-align:center">Client Contact</th>
                <th style="text-align:center">Email</th>
                {{-- <th style="text-align:center">Written By</th> --}}
                <th style="text-align:center">Action</th>
            </tr>
            @foreach($clients as $client)
                <tr>
                    <td style="text-align:center"><a href="/clients/{{$client->id}}">{{$client->client_name}}</a></td>
                    {{-- <td style="text-align:center"><a href="/client_order/{{$client->client_name}}">{{$client->client_name}}</a></td> --}}
                    <td style="text-align:center">{{$client->client_address}}</td>
                    <td style="text-align:center">{{$client->client_contact}}</td>
                    <td style="text-align:center">
                    @if ($client->email == '')
                        <p>No email.</p>
                    @else
                        {{$client->email}}
                    @endif
                    </td>
                    {{-- <td style="text-align:center">{{$client->user->name}}</td> --}}
                    <td style="text-align:center">
                        <div class='row-fluid'>
                            @if(!Auth::guest())
                                @if(Auth::user()->id == $client->user_id | Auth::user()->is_admin == 1)
                                    <a href="/clients/{{$client->id}}/edit" class="btn btn-secondary btn-sm" style="display:inline-block"><i class="fas fa-edit"></i> Edit</a>
                                    {{-- For Delete --}}
                                    {!!Form::open(['class'=>'delete','action' => ['ClientsController@destroy', $client->id], 'method' => 'POST', 'style' => 'display:inline-block'])!!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                        {{-- {{Form::submit('Delete', ['class' => 'btn btn-danger'])}} --}}
                                        <button class="delete btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</button>
                                    {!!Form::close()!!}
                                    @else
                                    <p>Not Authorized</p>
                                @endif
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
        <br>{{$clients->links()}} {{-- PAGINATE GARDA USE GARNI --}}
    @else
        <p>There are currently no clients.</p>
    @endif    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script>
        $(".delete").on("submit", function(){
            return confirm("Are you sure you wanna delete this client?");
        });
    </script>
</div>
@endsection