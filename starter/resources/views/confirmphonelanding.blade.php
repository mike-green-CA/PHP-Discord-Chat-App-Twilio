@extends('layout')
@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                
                <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                        <div class="card" data-background="color" data-color="blue">
                            <div class="card-header">
                                <h3 class="card-title">Thanks {{$_SESSION["username"]}}!</h3>
                            </div>
                            <div class="card-content">
                                <p>
                                    Age: {{$_SESSION["age"]}}, the email you entered was: {{$_SESSION["email"]}}.
                                </p>
                                <h6>Confirm Phone Number</h6>
                                <p>We have sent a message to:</p> 
                                <p>{{$_SESSION["phoneNum"]}}</p>
                                <p>please enter the code below.</p>
                                
                                    <form method="get" action="{{ route('phoneConfirm') }}">
                                        @csrf
                                        <div class="card" data-background="color" data-color="blue">
                                            <div class="card-header">
                                                <h3 class="card-title">Secret Code</h3>
                                            </div>
                                            <div class="card-content">                     
                                                    <div class="form-group">
                                                        <label for="trySecretCode">Your Code</label>
                                                        <input type="text" class="form-control" id="trySecretCode" name="trySecretCode" placeholder="Secret Code">
                                                    </div>
                                                <div class="form-group">
                                                <label for="trySecretCode">User info</label>
                                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="{{$_SESSION["username"]}}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <input type="email" placeholder="Enter email" name="email" class="form-control input-no-border" value="{{$_SESSION["email"]}}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="age" name="age" placeholder="Enter Age" value="{{$_SESSION["age"]}}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="phoneNum" name="phoneNum" placeholder="Enter Phone Number: ex 123-456-7890" value="{{$_SESSION["phoneNum"]}}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" placeholder="Password" name="password" id="password" class="form-control input-no-border" value="{{$_SESSION["password"]}}" readonly>
                                                </div>
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