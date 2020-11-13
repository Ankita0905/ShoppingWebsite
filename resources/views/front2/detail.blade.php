@extends('front2.layouts.master')

@section('content')
{!! Form::open(['route' => 'front.cart.add', 'method' => 'post', 'id' => 'ajax-submit', 'files' => 'true']) !!}
    {!! Form::hidden('id', $result->id) !!}

    <?php $path = env('PRODUCT_PATH'); ?>
    <div class="detail-block">
        <div class="row wow fadeInUp">

            <div class="col-xs-12 col-sm-6 col-md-5 gallery-holder">
                <div class="product-item-holder size-big single-product-gallery small-gallery">
                    <div id="owl-single-product">
                        <div class="single-product-gallery-item">
                            <a href="javascript:void(0)"> 
                                {!! img($path, $result->image, '100%', '__parent_img') !!}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class='col-sm-6 col-md-7 product-info-block'>
                <div class="product-info">
                    <h1 class="name">{!! $result->category_name !!}</h1>
                    @if($result->product_name != '')
                        <h4 class="name" style="color: #797979; margin-top: 0px;">
                            {!! $result->product_name !!}
                        </h4>
                    @endif

                    <div class="description-container m-t-20">
                       {!! $result->description !!}
                    </div>

                    <div class="price-container info-container m-t-20">
                        <div class="row">
                            <div class="col-md-12 m-t-20">
                                <div class="price-box">
                                    <span class="price" style="font-size: 30px;">${!! $result->price !!}</span>
                                </div>
                            </div>

                            <div class="col-md-6 m-t-10">
                                <h4>Quantity</h4>
                                <input type="number" min="1" value="1" name="quantity" class="form-control" />
                            </div> 
                            
                            <div class="col-md-6 m-t-10">
                                <button type="submit" class="btn btn-large btn-primary" style="margin-top:40px;">
                                    <i class="fa fa-shopping-cart inner-right-vs"></i> ADD TO CART
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{!! Form::close() !!}
@endsection

@section('bottom_script')
    <script>
        zoomSlider();
    </script>
@endsection