@extends('layout')
@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                    <form method="#" action="#">
                        <div class="card" data-background="color" data-color="blue">
                            <div class="card-header">
                                <h3>Thanks {{$name}}! 👏 </h3>
                            </div>
                            <div class="card-content">
                                <div class="col-md">
                                    <p>
                                        <img class="img-circle pull-left" src="https://cdn.discordapp.com/avatars/{{$id}}/{{$picture}}.png"/>
                                    </p>
                                    <p class="">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam nec sapien velit. Proin imperdiet vulputate mi. Etiam ac finibus leo. Integer in nibh lacinia, varius ligula suscipit, interdum lorem. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec molestie massa id ante tincidunt, et aliquam arcu maximus. Pellentesque hendrerit lorem elit, porta maximus ligula rutrum nec. Aenean vitae aliquet leo, vel faucibus urna. Quisque laoreet sed sem a convallis. In vulputate neque varius risus ullamcorper, id maximus libero malesuada. Nullam aliquam consectetur lobortis. Nam non vulputate arcu.
                                    </p>
                                    <p class="">
                                        {{ $email }}
                                    </p>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('dashboard') }}" type="button" class="btn btn-wd btn-primary btn-fill btn-rotate">
                                    Launch
                                    <span class="btn-label">
                                        <i class="ti-rocket"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

