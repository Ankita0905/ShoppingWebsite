@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col text-center">
            <h1 style="font-size: 60px; margin-top: 80px;">{!! __('common.401_heading') !!}</h1>
            <a class="btn btn-primary btn-lg" style="margin-top: 40px;" href="{!! route('home') !!}">
               <i class="fa fa-angle-double-left"></i> {!! __('common.go_back') !!}
            </a>
        </div>
    </div>
@endsection