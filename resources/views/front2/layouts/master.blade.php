<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <meta name="_token" content="{!! csrf_token() !!}" />
    <title>Canadian Electronic Store</title>
    <link rel="stylesheet" href="{!! asset('front2/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('front2/css/main.css') !!}">
    <link rel="stylesheet" href="{!! asset('front2/css/blue.css') !!}">
    <link rel="stylesheet" href="{!! asset('front2/css/owl.carousel.css') !!}">
    <link rel="stylesheet" href="{!! asset('front2/css/owl.transitions.css') !!}">
    <link rel="stylesheet" href="{!! asset('front2/css/animate.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('front2/css/rateit.css') !!}">
    <link rel="stylesheet" href="{!! asset('front2/css/bootstrap-select.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('front2/css/font-awesome.css') !!}">
    <link rel="stylesheet" href="{!! asset('front2/css/loading.css') !!}">
    <link rel="stylesheet" href="{!! asset('front2/css/custom.css') !!}">

    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
</head>
<body>

<div class="loading" style="display: none;">Loading &#8230;</div>

@include('front2.layouts.navbar-top')

<div class="body-content outer-top-xs">
    <div class='container'>
        <div class='row'>
            <div class='col-md-3 sidebar'>
                @include('front2.layouts.navbar')
            </div>

            <div class='col-md-9' style="margin-bottom: 20px;">
                @yield('content')
            </div>
        </div>
    </div>
    <footer id="footer" class="footer color-bg">
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="module-heading">
                            <h4 class="module-title">Contact Us</h4>
                        </div>

                        <div class="module-body">
                            <ul class="toggle-footer" style="">
                                <li class="media">
                                    <div class="pull-left"><span class="icon fa-stack fa-lg"> <i
                                                    class="fa fa-map-marker fa-stack-1x fa-inverse"></i> </span></div>
                                    <div class="media-body">
                                        <p>
                                            ABC Street Brampton<br> Canada
                                        </p>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="pull-left"><span class="icon fa-stack fa-lg"> <i
                                                    class="fa fa-mobile fa-stack-1x fa-inverse"></i> </span></div>
                                    <div class="media-body">
                                        <p>+1 6471234678</p>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="pull-left"><span class="icon fa-stack fa-lg"> <i
                                                    class="fa fa-envelope fa-stack-1x fa-inverse"></i> </span></div>
                                    <div class="media-body"><span><a href="#">techtribe@gmail.com</a></span></div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="module-heading">
                            <h4 class="module-title">Useful Links</h4>
                        </div>

                        <div class="module-body">
                            <ul class='list-unstyled'>
                                <li class="first"><a href="{!! route('front.login') !!}" title="My Account">My Account</a></li>
                                <li><a href="{!! route('front.cart') !!}" title="My Cart">My Cart</a></li>
                                <li><a href="{!! route('front.order-list') !!}" title="Order History">Order History</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         
    </footer>
</div>

@include('front2.layouts.modal')

<script src="{!! asset('front2/js/jquery-1.11.1.min.js') !!}"></script>
<script src="{!! asset('front2/js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('front2/js/bootstrap-hover-dropdown.min.js') !!}"></script>
<script src="{!! asset('front2/js/owl.carousel.min.js') !!}"></script>
<script src="{!! asset('front2/js/echo.min.js') !!}"></script>
<script src="{!! asset('front2/js/jquery.easing-1.3.min.js') !!}"></script>
<script src="{!! asset('front2/js/bootstrap-slider.min.js') !!}"></script>
<script src="{!! asset('front2/js/jquery.rateit.min.js') !!}"></script>
<script src="{!! asset('front2/js/bootstrap-select.min.js') !!}"></script>
<script src="{!! asset('front2/js/wow.min.js') !!}"></script>
<script src="{!! asset('front2/js/scripts.js') !!}"></script>
<script src="{!! asset('front2/js/zoomslider.js') !!}"></script>
<script src="{!! asset('js/script.js') !!}"></script>

@yield('bottom_script')
</body>