@extends('layouts.admin')

@section('content')
<div class = "container">
    <a href="/products" class='btn btn-default'><i class="far fa-hand-point-left"></i> Go Back</a>
    <br><br>
    {{-- <a align="right" href="/orders/create" class='btn btn-primary'>Order</a> --}}

    <h1>{{$product->name}}</h1>
    {{-- <img style="width:50%" src="/storage/product_images/{{$product->product_image}}"> --}}                 
    
    <hr>
    <div class="form-group"> 
        Quantity: {{$product->quantity}} <br>
        Rate: {{$product->rate}}
    </div>
    <small>Added on {{$product->created_at}} by {{$product->user->name}}</small>

    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $product->user_id | Auth::user()->is_admin == 1)
            <a href="/products/{{$product->id}}/edit" style="display:inline-block" class="btn btn-secondary"><i class="fas fa-edit"></i> Edit</a>
            {{-- For Delete --}}
            {!!Form::open(['action' => ['ProductsController@destroy', $product->id], 'method' => 'POST', 'class' => 'delete pull-right', 'style' => 'display:inline-block'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{-- {{Form::submit('Delete', ['class' => 'btn btn-danger'])}} --}}
                <button class=" delete btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
            {!!Form::close()!!}
            <a href="/products/{{$product->id}}/stock" style="display:inline-block" class="btn btn-primary"><i class="fas fa-plus"></i> &nbsp;Add Stock</a>
        @endif
    @endif
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script>
        $(".delete").on("submit", function(){
            return confirm("Are you sure you wanna delete this product?");
        });
    </script>
@endsection