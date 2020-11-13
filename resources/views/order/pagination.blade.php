<div class="col-lg-12 table-responsive">
    <table id="example" class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th width="5%">#</th>
            <th>{!! sorting('order_number', 'Order No', $sortOrder) !!}</th>
            <th>{!! sorting('name', 'Customer', $sortOrder) !!}</th>
            <th>{!! sorting('order_date', 'Order Date', $sortOrder) !!}</th>
            <th>{!! sorting('payment_mode', 'Pay Mode', $sortOrder) !!}</th>
            <th>{!! sorting('order_status', 'Status', $sortOrder) !!}</th>
            <th>{!! sorting('total_price', 'Total', $sortOrder) !!}</th>
            <th width="20%">{!! __('common.action') !!}</th>
        </tr>
        </thead>

        @if(isset($result) && count($result) > 0)
            <tbody>
                <?php 
                    $i = pageIndex($result); 
                    $paymentMode = paymentMode();
                    $orderStatus = orderStatus();
                ?>
                @foreach($result as $key => $row)
                    <tr>
                        <td>{!! $i++ !!}</td>
                        <td><a href="{!! route('order.edit', $row->id) !!}">{!! $row->order_number !!}</a></td>
                        <td>
                            <strong>Name: </strong>{!! $row->name !!} <br>
                            <strong>Email: </strong>{!! $row->email !!} <br>
                            <strong>Address: </strong>{!! $row->address ?? '--' !!}
                        </td>
                        <td>{!! dateFormat($row->order_date, 'd-m-Y') !!}</td>
                        <td>{!! $paymentMode[$row->payment_mode] ?? '--' !!}</td>
                        <td>{!! $orderStatus[$row->order_status] ?? '--' !!}</td>
                        <td>
                            <strong>Price: </strong>{!! $row->total_price !!}<br>
                            <strong>Items: </strong>{!! $row->total_item !!}
                        </td>
                        <td>
                            @if($row->order_status == 1)
                                <a class="btn btn-primary btn-sm" href="{!! route('order.edit', $row->id) !!}"><i class="fa fa-edit"></i> Confirm Order</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="9">
                        <div class="row">
                            <div class="col">{!! $result->links() !!}</div>
                            <div class="col text-right">{!! pageDetail($result) !!}</div>
                        </div>
                    </td>
                </tr>
            </tfoot>
        @else
            <tbody>
                <tr>
                    <td colspan="9">
                        <div class="text-center">{!! __('common.no_data_found') !!}</div>
                    </td>
                </tr>
            </tbody>
        @endif
    </table>
</div>