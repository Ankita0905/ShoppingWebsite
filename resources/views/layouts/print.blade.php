<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="_token" content="{!! csrf_token() !!}" />
    <link rel="stylesheet" href="{!! asset('assets/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/custom.css') !!}">
    @yield('css')
    <title>IMS | Admin Panel</title>
</head>
<body class="bg-light">

<div class="loading" style="display: none;">Loading &#8230;</div>

@yield('content')

<script src="{!! asset('assets/js/jquery-1.11.3.js') !!}"></script>

@yield('top_script')

<script src="{!! asset('assets/js/bootstrap.bundle.min.js') !!}"></script>
<script src="{!! asset('assets/js/bootadmin.min.js') !!}"></script>
<script src="{!! asset('assets/js/script.js') !!}"></script>

@yield('bottom_script')

</body>
</html>