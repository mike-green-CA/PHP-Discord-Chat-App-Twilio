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
                                <h6>Confirm the code sent to</h6>
                                <p>{{$_SESSION['phoneNum']}}</p>
                                
                                    <form method="post" action="{{ route('passwordResetCodeCheck') }}">
                                        @csrf
                                        <div class="card" data-background="color" data-color="blue">
                                            <div class="card-header">
                                                <h3 class="card-title">Secret Code</h3>
                                            </div>
                                            <div class="form-group">
                                                <label for="secretCode"></label>
                                                <input type="text" class="form-control" id="trySecretCode" name="trySecretCode" placeholder="">
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