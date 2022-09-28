@extends('layout')
@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                <form method="post" action="{{ route('confirmPhoneLanding') }}">
                    <div class="card" data-background="color" data-color="blue">
                        <div class="card-header">
                            <h3 class="card-title">Sign Up</h3>
                        </div>
                        <div class="card-content">
                                @csrf
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label>Email address</label>
                                    <input type="email" placeholder="Enter email" name="email" class="form-control input-no-border">
                                </div>
                                <div class="form-group">
                                    <label for="age">Age</label>
                                    <input type="text" class="form-control" id="age" name="age" placeholder="Enter Age">
                                </div>
                                <div class="form-group">
                                    <label for="phoneNum">Phone Number</label>
                                    <input type="text" class="form-control" id="phoneNum" name="phoneNum" placeholder="Enter Phone Number: ex 123-456-7890">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" placeholder="Password" name="password" id="password" class="form-control input-no-border">
                                </div>
                                <div class="form-group">
                                    <label>Verify Password</label>
                                    <input type="password" placeholder="Password" name="verify_password" id="verify_password" class="form-control input-no-border">
                                </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-fill btn-wd ">Let's go</button>
                            <div class="forgot">
                                <a href="#">Forgot your password?</a>
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
