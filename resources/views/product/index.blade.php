@extends('layouts.master')

@section('content')

    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="mb-4">@lang('menu.list_product')</h4>
        </div>
        <div class="col-md-6 text-right">
            <a href="{!! route('product.create') !!}" class="btn btn-primary">@lang('product.create_product')</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    {!! Form::open(['route' => 'product.index', 'method' => 'get', 'id' => 'form-search']) !!}
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group drop-icon-list">
                                            {!! Form::label('category') !!}
                                            {!! Form::select('category_id', $category, null, ['class' => 'form-control select2']) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group drop-icon-list">
                                            {!! Form::label('status') !!}
                                            {!! Form::select('status', status(), null, ['class' => 'form-control select2']) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary mt-25"><i class="fa fa-search"></i></button>
                                        <button class="btn btn-secondary mt-25" type="button" onclick="window.location.href = '{!! route('product.index') !!}'">
                                            <i class="fa fa-spinner"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            {!! Form::label('search') !!}
                                            <input class="form-control" name="keyword" placeholder="Search" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('per_page') !!}
                                            {!! Form::select('perPage', perPage(), null, ['class' => 'form-control select2', 'id' => 'perPage']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}

                    <div class="row" id="pagination" data-url="{!! route('product.index') !!}">
                        @include('product.pagination')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection