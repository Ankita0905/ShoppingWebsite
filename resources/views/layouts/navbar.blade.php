<div class="d-flex">
    <div class="sidebar sidebar-dark bg-dark">
        <ul class="list-unstyled">
            <li><a href="{!! route('home') !!}"> @lang('menu.dashboard')</a></li>

            <li>
                <a href="#category" data-toggle="collapse">
                    @lang('menu.category')
                </a>
                <ul id="category" class="list-unstyled collapse">
                    <li><a href="{!! route('category.create') !!}">@lang('menu.create_category')</a></li>
                    <li><a href="{!! route('category.index') !!}">@lang('menu.list_category')</a></li>
                </ul>
            </li> 
 
            <li>
                <a href="#product" data-toggle="collapse">
                    @lang('menu.product')
                </a>
                <ul id="product" class="list-unstyled collapse">
                    <li><a href="{!! route('product.create') !!}">@lang('menu.create_product')</a></li>
                    <li><a href="{!! route('product.index') !!}">@lang('menu.list_product')</a></li>
                </ul>
            </li>

            {{--<li>
                <a href="#material" data-toggle="collapse">
                    @lang('menu.material')
                </a>
                <ul id="material" class="list-unstyled collapse">
                    <li><a href="{!! route('material.create') !!}">@lang('menu.create_material')</a></li>
                    <li><a href="{!! route('material.index') !!}">@lang('menu.list_material')</a></li>
                </ul>
            </li>

            <li>
                <a href="#order" data-toggle="collapse">
                    @lang('menu.order')
                </a>
                <ul id="order" class="list-unstyled collapse">
                    <li><a href="{!! route('order.index') !!}">@lang('menu.list_order')</a></li>
                </ul>
            </li>--}}
            {{--<li><a href="{!! route('home.backup') !!}"><i class="fa fa-fw fa-download"></i> @lang('menu.backup')</a></li>--}}
        </ul>
    </div>

    <div class="content p-4">
        @yield('content')
    </div>
</div>