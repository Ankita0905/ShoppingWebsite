<div class="col-lg-12 table-responsive">
    <table id="example" class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th width="3%" class="text-center">
                <input class="__check_all" type="checkbox">
            </th>
            <th width="5%">#</th>
            <th>Image</th>
            <th>{!! sorting('product_name', 'Product Name', $sortOrder) !!}</th>
            <th>{!! sorting('category_name', 'Category Name', $sortOrder) !!}</th>
            <th>{!! sorting('status', 'Status', $sortOrder) !!}</th>
            <th width="20%">{!! __('common.action') !!}</th>
        </tr>
        </thead>

        @if(isset($result) && count($result) > 0)
            <tbody>
            @php
                $i = pageIndex($result);
                $path = env('PRODUCT_PATH');
            @endphp

            @foreach($result as $key => $row)
                <tr>
                    <td class="text-center">
                        <input name="toggle[]" type="checkbox" class="__check" value="{!! $row->id !!}">
                    </td>
                    <td>{!! $i++ !!}</td>
                    <td>{!! img($path, $row->image, '100px') !!}</td>
                    <td><a href="{!! route('product.edit', $row->id) !!}">{!! $row->product_name ?? 'No Name' !!}</a></td>
                    <td>{!! $row->category_name !!}</td>
                    <td>{!! statusSlider('product.status', $row->id, $row->status) !!}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{!! route('product.edit', $row->id) !!}"><i class="fa fa-edit"></i> Edit</a>
                        {{--<a class="btn btn-sm btn-danger __drop" href="javascript:void(0);" data-url="{!! route('product.destroy', $row->id) !!}"><i class="fa fa-trash"></i> Delete</a>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>

            <tfoot>
            <tr>
                <td colspan="11">
                    <button type="button" class="btn btn-success btn-sm __toggle_all" data-route="{!! route('product.toggle-all-status', 1) !!}"><i class="fa fa-check"></i> {!! __('common.active') !!}</button>
                    <button type="button" class="btn btn-danger btn-sm __toggle_all" data-route="{!! route('product.toggle-all-status', 0) !!}"><i class="fa fa-times"></i> {!! __('common.inactive') !!}</button>
                </td>
            </tr>
            <tr>
                <td colspan="11">
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
                <td colspan="11">
                    <div class="text-center">{!! __('common.no_data_found') !!}</div>
                </td>
            </tr>
            </tbody>
        @endif
    </table>
</div>