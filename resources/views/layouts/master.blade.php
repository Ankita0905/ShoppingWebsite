<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="_token" content="{!! csrf_token() !!}" />
    <link rel="stylesheet" href="{!! asset('assets/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/fontawesome-all.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/bootadmin.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/jquery-ui.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/select2.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/loading.css') !!}">
    {{--<link rel="stylesheet" href="{!! asset('assets/css/loader.css') !!}">--}}
    <link rel="stylesheet" href="{{ asset('assets/css/checkbox.css') }}" />
    <link rel="stylesheet" href="{!! asset('assets/css/custom.css') !!}">
    @yield('css')
    <title>Canadian Electronic Store</title>
</head>
<body class="bg-light">

<div class="loading" style="display: none;">Loading &#8230;</div>

@include('layouts.navbar-top')

@include('layouts.navbar')

@include('layouts.modal')

<script src="{!! asset('assets/js/jquery-1.11.3.js') !!}"></script>

@yield('top_script')

<script src="{!! asset('assets/js/bootstrap.bundle.min.js') !!}"></script>
<script src="{!! asset('assets/js/bootadmin.min.js') !!}"></script>
<script src="{!! asset('assets/js/jquery-ui.min.js') !!}"></script>
<script src="{!! asset('assets/js/select2.full.min.js') !!}"></script>
<script src="{!! asset('assets/js/ckeditor.js') !!}"></script>
<script src="{!! asset('assets/js/editor.js') !!}"></script>
<script src="{!! asset('assets/js/script.js') !!}"></script>

@yield('bottom_script')

</body>
</html>