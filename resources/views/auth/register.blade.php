@extends('layouts.admin')

@section('content')

<style>
    .center {
        margin: auto;
        width: 60%;
        border: 3px;
        padding: 10px;
    }

    .button {padding: 6px 130px;}
</style>

<div class="container center">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" align="center"><h3><b>{{ __('Register') }}</b></h3></div>

                <div class="panel-body">
                    @if (Auth::user()->is_admin == 1)

                    <form method="POST" action="{{ route('register') }}">
                        <hr>
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right" align="right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right" align="right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right" align="right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right" align="right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="input-wrpr">
                            {{-- <label for="is_admin" class="col-md-4 col-form-label text-md-right" align="right">{{ __('Is Admin?') }}</label> --}}
                            {!! Form::label('is_admin', 'Is Admin?', ['class'=>"col-md-4 col-form-label text-md-right", 'align'=>"right"]) !!}
                            {!! Form::checkbox('is_admin', true); !!}
                            {{-- <input type="checkbox" name="is_admin" id="myCheckbox" /> --}}

                        </div>


                        <br>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4" align="center">
                                <button type="submit" class="button btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    @else
                    <br>
                        <p align="center">Only admin can access this page.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <script>
    $(document).on('change','#myCheckbox',function(){
        if($(this).is(':checked')){
           $('#myCheckbox').val(1);
        }else{
           $('#myCheckbox').val(0);
        }
    });
</script> --}}
@endsection
