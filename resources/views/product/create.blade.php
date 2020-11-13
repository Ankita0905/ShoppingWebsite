@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card">
            {!! Form::open(['route' => 'product.store', 'method' => 'post', 'id' => 'ajax-submit', 'files' => 'true']) !!}
                <h5 class="card-header font-weight-bold">
                    @lang('product.create_product')
                </h5>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('category_id', 'Category') !!}
                                {!! Form::select('category_id', $category, null, ['class' => 'form-control select2']) !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('product_name') !!}
                                {!! Form::text('product_name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('price') !!}
                                {!! Form::text('price', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('status') !!}
                                {!! Form::select('status', status(), 1, ['class' => 'form-control select2']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('image') !!}
                                {!! Form::file('image', ['class' => 'form-control', 'accept' => 'image/*']) !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('description') !!}
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'editor', 'size' => '5x3']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary"> @lang('menu.save') </button>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection