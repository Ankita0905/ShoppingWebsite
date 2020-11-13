@extends('front2.layouts.master')

@section('content')
    <div class="body-content" style="min-height: 600px;">
        <div class="row">
            <div class="col-md-6">
                @if ($errors->has('address'))
                    <div class="alert alert-danger">
                        {!! $errors->first('address') !!}
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h4 class="">Place Order</h4>
                {!! Form::open(['route' => 'front.order-submit', 'method' => 'post', 'id' => 'payment-form', 'files' => 'true', 'class' => 'register-form outer-top-xs']) !!}
                    <input type="text" id="__token" name="stripe_token" style="display: none;" />
                    <div class="form-group">
                        <label class="info-title" for="order_number">Order Number</label>
                        <input name="order_number" type="text" class="form-control unicase-form-control text-input" id="order_number" value="{!! $orderNumber !!}" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label class="info-title" for="total_price">Total Price</label>
                        <input name="total_price" value="{!! cartTotal() !!}" type="text" class="form-control unicase-form-control text-input" id="total_price" readonly="readonly">
                    </div>

                    <div class="form-group">
                        <label class="info-title" for="payment_mode">Payment Mode</label>
                        <select name="payment_mode" class="form-control">
                            <option value="1">Cash</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="info-title" for="address">Address</label>
                        <textarea name="address" class="form-control unicase-form-control text-input">{!! authAddress() !!}</textarea>
                    </div>

                    <div class="form-group m-t-20">
                        <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Place Order</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection