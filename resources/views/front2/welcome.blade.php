@extends('front2.layouts.master')

@section('content')

    @if(!$categoryId)
        @include('front2.layouts.banner')
    @endif

    @if(isset($products) && count($products) > 0)
        <?php $count = 1; ?>
        <div class="clearfix filters-container m-t-10">
            <div class="row text-right">
                <div class="col col-sm-12 col-md-12">
                    {!! $products->links() !!}
                </div>
            </div>
        </div>

        <div class="search-result-container">
            <div id="myTabContent" class="tab-content category-list">
                <div class="tab-pane active " id="grid-container">
                    <div class="category-product">
                        <div class="row">
                            <?php $path = env('PRODUCT_PATH'); ?>
                            @foreach($products as $i => $product)
                                <div class="col-sm-6 col-md-4 wow fadeInUp">
                                    <div class="products">
                                        <div class="product">
                                            <div class="product-image">
                                                <div class="image myimage">
                                                    <a href="{!! route('front.detail', $product->id) !!}">
                                                        {!! img($path, $product->image, '100%', '__myimage') !!}
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="product-info text-left">
                                                <h3 class="name">
                                                    <a href="{!! route('front.detail', $product->id) !!}">
                                                        <strong>{!! $product->category_name !!}</strong>
                                                        @if($product->product_name != '')
                                                            - <span style="font-size: 12px; color: #9a9a9a;">{!! $product->product_name !!}</span>
                                                        @endif
                                                    </a>
                                                </h3>

                                                <div class="product-price">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <span class="price"> ${!! $product->price !!} </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($count%3 == 0)
                                    <div style="display: block; content: ''; clear: both;"></div>
                                @endif
                                <?php $count++; ?>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix filters-container m-t-10">
                <div class="row text-right">
                    <div class="col col-sm-12 col-md-12">
                        {!! $products->links() !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col col-sm-12 col-md-12">
                <div class="alert alert-danger">
                    No Products !
                </div>
            </div>
        </div>
    @endif
@endsection