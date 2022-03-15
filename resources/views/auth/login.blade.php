@extends('layouts.admin')

@section('content')
<style>
    .center {
        margin: auto;
        width: 60%;
        border: 3px;
        padding: 10px;
    }

    .button {padding: 6px 140px;}
</style>
<div class="container center">
    <div class="row justify-content-center">
        <div class="col-md-12" >
            <div class="panel panel-default">
                <div class="panel-heading" align="center"><h2><b>{{ __('Login') }}</b></h2></div>
                <br>
                <div class="panel-body">
                    <form method="POST" action="{{ route('login') }}">
                        <hr>
                        @csrf
                        <br>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right" align="right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"  align="right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4 offset-md-3" align="center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <small><label class="form-check-label" for="remember">
                                        {{ __('Remember me') }}
                                    </label></small>

                                    
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-5 offset-md-4" align="center" >
                                <button type="submit" class="button btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                
                                
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-4" align="center">
                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
