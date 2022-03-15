@extends('layouts.admin')

@section('content')
<style>
    .fa-cog {
      color: red;
    }
  </style>
<div class="container">
    <h1 align="center">Products</h1>
    <hr>
    <a href="/products/create" class='btn btn-primary'><i class="fas fa-plus"></i> &nbsp;&nbsp;Add Product</a>
    <hr>
    @if(count($products) > 0)
        <table class= "table table-responsive table-condensed table-hover table-striped table-bordered table-sm">
            <tr>
                {{-- <th>Product Image</th> --}}
                <th style="text-align:center">Product Name</th>
                <th style="text-align:center">Quantity</th>
                <th style="text-align:center">Rate</th>
                <th style="text-align:center">Action</th>
                {{-- <th>User</th> --}}
            </tr>
            @foreach($products as $product)
                <tr style="text-align:center">
                    {{-- <td>
                        <a href="/products/{{$product->id}}">
                            <div class="col-md-4 col-sm-4">
                                <img style="width:100px;height:100px" src="/storage/    product_images/{{$product->product_image}}">           //IMAGE
                            </div>
                        </a>
                    </td> --}}
                    <td><a href="/products/{{$product->id}}">{{$product->name}}</a></td>
                    @if ($product->quantity > 9)
                        <td>{{$product->quantity}}</td>
                    @else                    
                        <td>{{$product->quantity}}<i class="fa-cog fas fa-exclamation-triangle" style="float: right;"></i></td>                       
                    @endif                    
                    
                    <td>{{$product->rate}}</td>
                    
                    <td>
                        <div class='row-fluid row mb-0'>
                            <div class="col-md-12 offset-md-2">
                            @if(!Auth::guest())
                                @if(Auth::user()->id == $product->user_id | Auth::user()->is_admin == 1)
                                    <a href="/products/{{$product->id}}/edit" class="btn btn-secondary btn-sm" style="display:inline-block"><i class="fas fa-edit"></i> Edit</a>
                                    {{-- For Delete --}}
                                    {!!Form::open(['class'=>'delete', 'action' => ['ProductsController@destroy', $product->id], 'method' => 'POST', 'style' => 'display:inline-block'])!!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                        {{-- {{Form::submit('Delete', ['class' => 'btn btn-danger'])}} --}}
                                        <button class="delete btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</button>
                                    {!!Form::close()!!}
                                    {{-- <a href="/products/{{$product->id}}/stock" class="btn btn-primary">Add Stock</a> --}}
                                    @else
                                    <p>Not Authorized</p>
                                @endif
                            @endif
                            </div>
                        </div>
                    </td>
                    {{-- <td>Written on {{$product->created_at}} by {{$product->user->name}}</td> --}}
                    
                </tr>
            @endforeach
        </table>

        <br>
        {{$products->links()}} {{-- PAGINATE GARDA USE GARNI --}}
    @else
        <p>There are currently no items in inventory.</p>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script>
        $(".delete").on("submit", function(){
            return confirm("Are you sure you wanna delete this product?");
        });
    </script>
    </div>
@endsection