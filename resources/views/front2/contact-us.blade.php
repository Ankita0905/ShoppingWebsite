@extends('front2.layouts.master')

@section('content')

    <div class="contact-page">
        <div class="row">
            <div class="col-md-8 contact-form">
                {!! Form::open(['route' => 'front.contact-submit', 'method' => 'post', 'id' => 'ajax-submit', 'files' => 'true']) !!}
                    <div class="col-md-6 register-form">
                        <div class="form-group">
                            <label class="info-title" for="name">Your Name</label>
                            <input type="text" name="name" class="form-control unicase-form-control text-input"
                                   id="name" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6 register-form">

                        <div class="form-group">
                            <label class="info-title" for="email">Email Address</label>
                            <input type="email" name="email" class="form-control unicase-form-control text-input"
                                   id="email" placeholder="">
                        </div>
                    </div>

                    <div class="col-md-12 register-form">
                        <div class="form-group">
                            <label class="info-title" for="message">Your Message</label>
                            <textarea class="form-control unicase-form-control" name="message" id="message"></textarea>
                        </div>
                    </div>

                    <div class="col-md-12 outer-bottom-small m-t-20">
                        <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Submit Details</button>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="col-md-4 contact-info">
                <div class="clearfix address">
                    <span class="contact-i"><i class="fa fa-map-marker"></i></span>
                    <span class="contact-span">
                        ABC Street Brampton<br>
                        Canada
                    </span>
                </div>
                <div class="clearfix phone-no">
                    <span class="contact-i"><i class="fa fa-mobile"></i></span>
                    <span class="contact-span">
                    +1 6471234678
                    </span>
                </div>
                <div class="clearfix email">
                    <span class="contact-i"><i class="fa fa-envelope"></i></span>
                    <span class="contact-span"><a href="#">techtribe@gmail.com</a></span>
                </div>
            </div>
        </div>
        <!-- /.contact-page -->
    </div>
@endsection