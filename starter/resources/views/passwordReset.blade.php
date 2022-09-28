@extends('layout')
@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                
                <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                        <div class="card" data-background="color" data-color="blue">
                            <div class="card-header">
                                <h3 class="card-title">To reset your password please follow the instructions!</h3>
                            </div>
                            <div class="card-content">
                                <h6>Please Enter a new password</h6>
                                
                                    <form method="post" action="{{ route('passwordReset') }}">
                                        @csrf
                                        <div class="card" data-background="color" data-color="blue">
                                            <div class="card-header">
                                                <h3 class="card-title">Secret Code</h3>
                                            </div>
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" placeholder="Password" name="password" id="password" class="form-control input-no-border">
                                            </div>
                                            <div class="form-group">
                                                <label>Verify Password</label>
                                                <input type="password" placeholder="Password" name="verify_password" id="verify_password" class="form-control input-no-border">
                                            </div>
                                                
                                            <div class="card-footer text-center">
                                                <button type="submit" class="btn btn-fill btn-wd ">Confirm</button>
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
                            <div class="card-footer text-center">
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@stop