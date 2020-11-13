@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                {!! Form::model($result, ['route' => ['product.update', $result->id], 'method' => 'patch', 'id' => 'ajax-submit']) !!}
                <h5 class="card-header font-weight-bold">
                    @lang('product.edit_product') #{!! $result->product_name ?? 'No Name' !!}
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
                                {!! Form::select('status', status(), null, ['class' => 'form-control select2']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('image') !!}
                                {!! Form::file('image', ['class' => 'form-control', 'accept' => 'image/*']) !!}
                                {!! img(env('PRODUCT_PATH'), $result->image, '100px') !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('description') !!}
                                {!! Form::textarea('description', $result->description, ['class' => 'form-control', 'id' => 'editor', 'size' => '5x3']) !!}
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