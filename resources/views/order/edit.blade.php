@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                {!! Form::model($result, ['route' => ['order.update', $result->id], 'method' => 'patch', 'id' => 'ajax-submit']) !!}
                <h5 class="card-header font-weight-bold">
                   Confirm Order #{!! $result->order_number !!}
                </h5>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('name', 'Customer Name') !!}
                                {!! Form::text('name', null, ['class' => 'form-control', 'readonly' => true]) !!}
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('email', 'Customer Email') !!}
                                {!! Form::text('email', null, ['class' => 'form-control', 'readonly' => true]) !!}
                            </div>
                        </div>

                        {{-- <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('order_status') !!}
                                {!! Form::select('order_status', orderStatus(), 2, ['class' => 'form-control select2']) !!}
                            </div>
                        </div> --}}

                        <input type="hidden" value="2" name="order_status" />
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary"> Confirm & Mail Order </button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection