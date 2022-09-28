@extends('layout')
@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                    <form method="#" action="#">
                        <div class="card" data-background="color" data-color="blue">
                            <div class="card-header">
                                <h3 class="card-title">All signed up! {{$username}}!</h3>
                            </div>
                            <div class="card-content">
                                <p>
                                    Age: {{$age}}, the email you entered: {{$email}}.
                                </p>
                            </div>
                            <div class="card-footer text-center">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
