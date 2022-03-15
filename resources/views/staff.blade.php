@extends('layouts.admin')

@section('content')
    <div class = "container">
        <h1 align="center">Staffs</h1>
    <hr>
    @if (Auth::user()->is_admin == 1)

    <a href="/register" class='btn btn-primary'><i class="fas fa-plus"></i> &nbsp;&nbsp;Add Staff</a>
    <hr>

    @endif
    @if(count($staff) > 0)
        @if (Auth::user()->is_admin == 1)
        <table class= "table table-responsive table-condensed table-hover table-striped table-bordered table-sm">
            <tr>
                {{-- <th>Product Image</th> --}}
                <th style="text-align:center">Name</th>
                <th style="text-align:center">Email</th>
                <th style="text-align:center">Is Admin?</th>
                <th style="text-align:center">Action</th>
            </tr>

            @foreach($staff as $staffs)
                {{-- @if (Auth::user()->is_admin == 0) --}}
                {{-- @if ($staffs->is_admin == 0) --}}
                <tr style="text-align:center">
                    
                    <td>{{$staffs->name}}</td>
                    <td>{{$staffs->email}}</td>
                    <td>
                        @if ($staffs->is_admin == 1)
                            <p>Yes</p>
                        @else
                            <p>No</p>
                        @endif    
                    </td>
                    <td style='white-space: nowrap'>
                        <div class='row-fluid'>
                            <div class="col-md-12 offset-md-0">

                            @if(!Auth::guest())
                                @if(Auth::user()->is_admin == 1)
                                    {{-- <a href="/orders/{{$order->bill_id}}/edit" class="btn btn-secondary" style="display:inline-block">Edit</a> --}}
                                    {{-- <a href="/staffs/{{$staffs->id}}/payment" class="btn btn-info btn-sm"><i class="fas fa-dollar-sign"></i> Edit Payment</a> --}}
                                    {{-- For Delete --}}
                                    {!!Form::open(['class'=>'delete','action' => ['DashboardController@del', $staffs->id], 'method' => 'POST', 'style' => 'display:inline-block'])!!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                        
                                        <button class="btn btn-danger btn-sm delete"><i class="fas fa-trash-alt"></i> Delete</button>
                                    {!!Form::close()!!}
                                    {{-- <a href="{{ route('user.delete', $staffs->id) }}">Delete this user</a> --}}
                                @else
                                    <p>Not Authorized</p>
                                @endif
                            @endif
                            </div>
                        </div>
                    </td>
                    
                </tr>
                {{-- @endif --}}

            @endforeach

        </table>
        @else
            <p>Only admin can access this page.</p>
        @endif

        
    @else
        <p>There are currently no staff.</p>
    @endif
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script>
        $(".delete").on("submit", function(){
            return confirm("Are you sure you wanna delete this user?");
        });
    </script>
@endsection