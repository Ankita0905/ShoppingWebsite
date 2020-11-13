@extends('front2.layouts.master')

@section('content')
    <div class="body-content" style="min-height: 600px;">

        <div class="row">
            <div class="col-md-6">
                <h4 class="">Sign Up</h4>
                {!! Form::open(['route' => 'front.register-submit', 'method' => 'post', 'id' => 'ajax-submit', 'files' => 'true', 'class' => 'register-form outer-top-xs']) !!}
                    <div class="form-group">
                        <label class="info-title" for="name">Name <span>*</span></label>
                        <input name="name" type="text" class="form-control unicase-form-control text-input" id="name">
                    </div>
                    <div class="form-group">
                        <label class="info-title" for="mobile_number">Mobile Number <span>*</span></label>
                        <input name="mobile_number" type="text" class="form-control unicase-form-control text-input" id="mobile_number">
                    </div>
                    <div class="form-group">
                        <label class="info-title" for="email">Email Address <span>*</span></label>
                        <input name="email" type="email" class="form-control unicase-form-control text-input"
                               id="email">
                    </div>
                    <div class="form-group">
                        <label class="info-title" for="password">Password <span>*</span></label>
                        <input name="password" type="password" class="form-control unicase-form-control text-input"
                               id="password">
                    </div>

                    <div class="form-group">
                        <label class="info-title" for="confirm_password">Confirm Password <span>*</span></label>
                        <input name="confirm_password" type="password" class="form-control unicase-form-control text-input"
                               id="password">
                    </div>

                    <div class="form-group">
                        <label class="info-title" for="address">Address <span>*</span></label>
                        <textarea name="address" type="text" class="form-control unicase-form-control text-input" id="address"></textarea>
                    </div>

                    <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Create An Account
                    </button>
                    <a href="{!! route('front.login') !!}" class="forgot-password pull-right">Already Registered?</a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection