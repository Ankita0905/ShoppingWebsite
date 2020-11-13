@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                {!! Form::model($result, ['route' => ['category.update', $result->id], 'method' => 'patch', 'id' => 'ajax-submit']) !!}
                <h5 class="card-header font-weight-bold">
                    @lang('category.edit_category') #{!! $result->category_name !!}
                </h5>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('category_name') !!}
                                {!! Form::text('category_name', null, ['class' => 'form-control']) !!}
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
                            <button class="btn btn-primary"> @lang('menu.save') </button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection