<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>COMP 4669</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/css/dashboard.css" rel="stylesheet"/>
    <link href="/assets/css/demo.css" rel="stylesheet" />


    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="/assets/css/themify-icons.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-transparent navbar-absolute">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">COMP 4669</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{{ route('login')}}">
                        Login
                    </a>
                </li>
                <li>
                    <a href="{{ route('signup')}}">
                        Sign Up
                    </a>
                </li>
                <li>
                    <a href="{{ route('about')}}">
                        About
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="wrapper wrapper-full-page">
    <div class="full-page login-page" data-color="blue" data-image="/assets/img/background/background-2.jpg">
        @yield('content')
        <footer class="footer footer-transparent">
            <div class="container">
                <div class="copyright">
                    Gary Tong
                </div>
            </div>
        </footer>
    </div>
</div>
</body>

<!--   Core JS Files. Extra: TouchPunch for touch library inside jquery-ui.min.js   -->
<script src="/assets/js/jquery.min.js" type="text/javascript"></script>
<script src="/assets/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="/assets/js/perfect-scrollbar.min.js" type="text/javascript"></script>
<script src="/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/js/demo.js"></script>

<script type="text/javascript">
    $().ready(function(){
        demo.checkFullPageBackgroundImage();

        setTimeout(function(){
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>

</html>
