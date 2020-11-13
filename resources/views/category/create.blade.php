@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card">
            {!! Form::open(['route' => 'category.store', 'method' => 'post', 'id' => 'ajax-submit', 'files' => 'true']) !!}
            <h5 class="card-header font-weight-bold">
                @lang('category.create_category')
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
                            {!! Form::select('status', status(), 1, ['class' => 'form-control select2']) !!}
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