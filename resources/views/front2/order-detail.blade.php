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
                    </tr>
                </thead>
                
                @php $l = 1; @endphp
                @if(isset($result) && count($result) > 0)
                    <tbody>
                        @foreach($result as $row)
                        <tr>
                            <td class="text-center">{!! $l++ !!}</td>
                            <td class="text-center">{!! $row->category_name !!}</td>
                            <td class="text-center">{!! $row->product_name !!}</td>
                            <td class="text-center"><strong>${!! (float) $row->price !!}</strong></td>
                            <td class="text-center">{!! $row->quantity !!}</td>
                            <td class="text-center"><strong>${!! (float) $row->total_price !!}</strong></td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">No Records</td>
                        </tr>
                </tbody>
                @endif
            </table>
        </div>   
    </div>
</div>