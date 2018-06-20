<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- //for-mobile-apps -->
    <link href="/css/user/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" type="text/css" href="/css/user/jquery-ui.css">
    <link href="/css/user/style.css?v=6" rel="stylesheet" type="text/css" media="all" />
    <!-- js -->
    <script type="text/javascript" src="/js/user/jquery-2.1.4.min.js"></script>
    <!-- //js -->
    <!-- cart -->

    <!-- cart -->
    <!-- for bootstrap working -->
    <script type="text/javascript" src="/js/user/bootstrap-3.1.1.min.js"></script>
    <!-- //for bootstrap working -->
    <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,900,900italic,700italic' rel='stylesheet' type='text/css'>
    <script src="/js/user/jquery.easing.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @include('partials.user._messages')
    @yield('title')
    @yield('styles')
</head>
<body>
<!-- header-bot -->
<?php
    $index_array = ['company_name','company_contact','company_address','company_email','company_about','company_logo'];
    $info = explode(PHP_EOL,Storage::disk('public')->get('company.txt'));
    $obj = new \stdClass();
    foreach ($info as $item) {
        foreach ($index_array as $index) {
            if(preg_match("/$index/",$item)){
                $replace = $index."=";
                $str = trim(preg_replace("/$replace/",'',$item));
                $obj->$index = $str;
                break;
            }
        }
    }
?>
<div class="header-bot">
    <div class="container">
        <div class="col-md-3 header-left">
            <h1><a href="/"><img src="/images/logo/{{$obj->company_logo}}"></a></h1>
        </div>
        <div class="col-md-6 header-middle">
            <form action="{{Route('user.search')}}" method="get">
                <div class="search">
                    <input name="search_item" type="search" value="Search" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}" required="">
                </div>
                <div class="sear-sub">
                    <input type="submit" value="">
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
        <div class="col-md-3 header-right footer-bottom">
            <ul>
                @if(Auth::guest())
                    <li><a href="/login" class="use1"><span>Login</span></a></li>
                @elseif(Auth::user())
                    <li><a href="{{route('user.account.settings')}}" class="use1"><span>{{Auth::user()->name}}</span></a></li>
                @endif
                <li><a class="fb" href="facebook.com"></a></li>
                <li><a class="twi" href="twitter.com"></a></li>
                <li><a class="insta" href="instagram.com"></a></li>
                    <li><a class="you" href="youtube.com"></a></li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- //header-bot -->
<!-- banner -->
<div class="ban-top">
    <div class="container">
        <div class="top_nav_left">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse menu--shylock" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav menu__list">
                            <li class=" menu__item"><a class="menu__link" href="/">Home</a></li>
                            @include('partials.user.menu')
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="top_nav_right">
            <div class="cart box_1">
                <a href="/cart">
                    <h3>
                        <div class="total">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            <span class="simpleCart_quantity"></span>
                        </div>
                    </h3>
                </a>
                <p id="simpleCart_quantity">Empty Cart</p>

            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- //banner-top -->
<!-- banner -->
@yield('page-head')
@yield("banner")
<!-- mens -->
        @yield('content')
        @include('partials.user._messages')
<!-- footer -->
<div class="footer">
    <div class="container">
        <div class="col-md-3 footer-left">

            <h2><a href="index.html"><img src="/images/logo/{{$obj->company_logo}}" alt=" " /></a></h2>
            <p>{{$obj->company_address}}</p>
            <p>{{$obj->company_email}}</p>
            <p>{{$obj->company_contact}}</p>
        </div>
        <div class="col-md-9 footer-right">
            <div class="col-sm-6 newsleft">
                <h3>SIGN UP FOR NEWSLETTER !</h3>
            </div>
            <div class="col-sm-6 newsright">
                <form>
                    <input type="text" value="Email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email';}" required="">
                    <input type="submit" value="Submit">
                </form>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <p class="copy-right">&copy 2016 Smart Shop. All rights reserved | Developed by <a href="http://soft360d.com/">360&deg Software</a></p>
    </div>
</div>
<!-- //footer -->
<!-- login -->

<script>
    $(document).ready(function(){
        @if(Session::has('success_link_share'))
                   $('#success_link_share').modal('show');
        @endif
        @if(Session::has('has_request_share'))
                   $('#share-link').modal('show');
        @endif
        @if(Session::has('registration_confirmation'))
                   $('#registration_confirmation').modal('show');
        @endif
         @if(Session::has('correct_email_reset'))
                   $('#correct_email_reset').modal('show');
        @endif
         @if(Session::has('false_email_reset'))
                   $('#false_email_reset').modal('show');

        @endif

        @if(Session::has('success_password_reset'))
            $('#success_password_reset').modal('show');
        @endif

        @if(Session::has('success_subscriber_message'))
            $('#success_subscriber_message').modal('show');
        @endif
             @if(Session::has('subscriber_exist'))
            $('#subscriber_exist').modal('show');
        @endif
             @if(Session::has('unauth_success_subscriber'))
            $('#unauth_success_subscriber').modal('show');
        @endif



    $('[data-toggle="tooltip"]').tooltip();
        if(localStorage.getItem('productId')){
            if(JSON.parse(localStorage.getItem('productId')).length>0){
                $('#simpleCart_quantity').text(JSON.parse(localStorage.getItem('productId')).length+" items in your cart.");
            }
        }
    });
</script>
    @yield('scripts')
</body>
</html>
