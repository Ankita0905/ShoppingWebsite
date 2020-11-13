@extends('front2.layouts.master')

@section('content')
    <?php $path = env('PRODUCT_PATH'); ?>
    <div class="row" style="min-height: 600px;">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Sr No</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Total</th>
                            <th width="200px" class="text-center">Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @php $l = 1; @endphp
                        @if(isset($cart) && count($cart) > 0)
                            @foreach($cart as $id => $c)
                            <tr>
                                <td>{!! $l++ !!}</td>
                                <td>{!! $c['category_name'] !!}</td>
                                <td>{!! $c['product_name'] !!}</td>
                                <td class="text-center">
                                    <strong>${!! (float) $c['price'] !!}</strong>
                                </td>
                                <td class="text-center"><strong>{!! $c['quantity'] !!}</strong></td>
                                <td class="text-center">
                                    <strong>${!! (float) $c['total'] !!}</strong>
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="{!! route('front.update-detail', $id) !!}"><i class="fa fa-edit"></i></a>
                                    <button class="btn btn-primary __cart_remove" type="button" data-product="{!! $id !!}" data-url="{!! route('front.cart.remove') !!}"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach

                            <tr style="font-size: 22px; border-top: 1px solid #e3e3e3;">
                                <td colspan="4">&nbsp;</td>
                                <td colspan="2" class="text-right">Total Price</td>
                                <td>${!! cartTotal() !!}</td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="7" class="text-center">No Item in cart!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>   
        </div>

        <div class="col-md-12">
            @if(isset($cart) && count($cart) > 0)
                <a href="{!! route('front.order') !!}" class="btn btn-primary btn-large" style="padding: 15px 35px;">
                    Place Your Order (Rs. {!! cartTotal() !!}) <i class="fa fa-fw fa-chevron-right"></i>
                </a>
            @endif
        </div>
    </div>
@endsection