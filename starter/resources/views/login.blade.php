@extends('layout')
@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                <form method="POST" action="{{ route('loginAuthorization') }}">
                    <div class="card" data-background="color" data-color="blue">
                        <div class="card-header">
                            <h3 class="card-title">Login</h3>
                        </div>
                        <div class="card-content">
                        @csrf
                            <div class="form-group">
                                <label>Email address</label>
                                <input type="email" name="email" id="email" placeholder="Enter email" class="form-control input-no-border">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" id="password" placeholder="Password" class="form-control input-no-border">
                        </div>
                            </div>
                        <div class="card-footer text-center">
                            <div>
                                <button type="submit" class="btn btn-fill btn-wd ">Let's go</button>
                            </div>
                            <div>
                                <span>
                                    or
                                </span>
                            </div>
                            <a href="{{ route('discord') }}" class="btn btn-light btn-wd ">
                                <i class="ti-facebook"></i>
                                Login with Discord!
                            </a>
                            <div class="forgot">
                                <a href="{{route('forgotPassword')}}">Forgot your password?</a>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        {{ $error }} <br/>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
