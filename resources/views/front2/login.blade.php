@extends('front2.layouts.master')

@section('content')
    <div class="body-content" style="min-height: 600px;">
        <div class="row">
            <div class="col-md-6">
                <h4 class="">Sign in</h4>

                {!! Form::open(['route' => 'front.login-submit', 'method' => 'post', 'id' => 'ajax-submit', 'files' => 'true', 'class' => 'register-form outer-top-xs']) !!}
                    <div class="form-group">
                        <label class="info-title" for="email">Email Address <span>*</span></label>
                        <input name="email" type="email" class="form-control unicase-form-control text-input" id="email">
                    </div>
                    <div class="form-group">
                        <label class="info-title" for="password">Password <span>*</span></label>
                        <input name="password" type="password" class="form-control unicase-form-control text-input" id="password">
                    </div>
                    <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Sign In</button>
                    <a href="{!! route('front.register') !!}" class="forgot-password pull-right">Create An Account?</a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection