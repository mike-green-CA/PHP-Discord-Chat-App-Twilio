@extends('layout')
@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                
                <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                        <div class="card" data-background="color" data-color="blue">
                            <div class="card-header">
                                <h3 class="card-title">Your password has been reset!</h3>
                            </div>
                            <div class="card-content">
                                <h6>To continue to Log in please press the button below.</h6>
                                
                                <a href="{{ route('passwordResetToLogin') }}" class="btn btn-fill btn-wd ">
                                    Login!
                                </a>

                            </div>
                            <div class="card-footer text-center">
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@stop