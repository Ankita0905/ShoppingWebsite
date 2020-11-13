@extends('front2.layouts.master')

@section('content')
    <?php $productPath = env('PRODUCT_PATH'); ?>
    <div class="row" style="min-height: 600px;">
        <div class="col-md-12">
            <h2>Order History</h2>
        </div>

        <div class="col-md-12 m-t-20">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Order No</th>
                            <th class="text-center">Order Date</th>
                            <th class="text-center">Pay Mode</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Items</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @if(isset($result) && count($result) > 0)
                            @foreach($result as $row)
                                <tr>
                                    <td class="text-center"><strong>#{!! $row->order_number !!}</strong></td>
                                    <td class="text-center">{!! dateFormat($row->order_date) !!}</td>
                                    <td class="text-center">{!! paymentMode($row->payment_mode) !!}</td>
                                    <td class="text-center">{!! orderStatus($row->order_status) !!}</td>
                                    <td class="text-center" style="text-align: right"><strong>${!! $row->total_price !!}</strong></td>
                                    <td class="text-center" style="text-align: right">{!! $row->total_item !!}</td>
                                    <td>
                                        <a data-url={!! route('front.order-detail', $row->id) !!} class="btn btn-success __show btn-sm" data-url={!! route('front.order-detail', $row->id) !!}>
                                            <i class="fa fa-eye"></i> View
                                        </a>

                                        @if($row->order_status != 3)
                                            <a data-url={!! route('front.order-cancel', $row->id) !!} class="btn btn-danger __cancel_order btn-sm" data-url={!! route('front.order-cancel', $row->id) !!}>
                                                <i class="fa fa-close"></i> Cancel
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="7">
                                    {!! $result->links() !!}
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="7" class="text-center">
                                    No Orders!
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>   
        </div>
    </div>
@endsection