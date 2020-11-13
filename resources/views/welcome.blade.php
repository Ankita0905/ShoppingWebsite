@extends('front.layouts.master')

@section('slider')
    @include('front.layouts.slider')
@endsection

@section('content')
    @if(isset($products) && count($products) > 0)
        <h4>Latest Products </h4>
        <ul class="thumbnails">
            @foreach($products as $i => $product)
                <li class="span3">
                    <div class="thumbnail">
                        <a href="product_details.html">
                            <img src="{!! asset('themes/images/products/6.jpg') !!}" alt=""/>
                        </a>
                        <div class="caption">
                            <h5>{!! $product->product_name !!}</h5>
                            <h4 style="text-align:center">
                                <a class="btn" href="#">View Details</a> 
                            </h4>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        {!! $products->links() !!}
    @endif
@endsection