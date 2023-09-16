@extends('components.backend.layout')

@section('contents')
<!-- Content Header (Page header) -->
@php
$breadcrumb = '<li class="breadcrumb-item"><a href="#">Dashboard</a></li>';
$breadcrumb .= '<li class="breadcrumb-item"><a href="#">Coupon</a></li>';
$breadcrumb .= '<li class="breadcrumb-item">Create</li>';
@endphp
<x-backend-breadcrumb title="Coupon" breadcrumb="{{$breadcrumb}}" />
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- .card-header -->
                    <div class="card-header">
                        @include('components.backend.alert.validation-error')
                    </div>
                    <!-- /.card-header -->

                    {{ Form::open(['url' => URL::to('backend/coupon/store'),  'method' => 'Post']) }}
                    <!-- .card-body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Coupon Code*</label>
                                    {{ Form::text('coupon_code', old('coupon_code'), ['class' => 'form-control', 'style' => 'text-transform:uppercase;']) }}
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Coupon Type*</label> <br>
                                    {{ Form::radio('coupon_type', \App\Models\Coupon::COUPON_TYPE_GENERALIZED,  true ) }} Generalized
                                    {{-- {{ Form::radio('coupon_type', 'Personalized',  false) }} Personalized &nbsp --}}
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Discount Type*</label> <br>
                                    {{ Form::radio('discount_type', \App\Models\Coupon::DISCOUNT_TYPE_PER,  true) }} Percentage &nbsp
                                    {{ Form::radio('discount_type', \App\Models\Coupon::DISCOUNT_TYPE_AMOUNT,  false ) }} Amount
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Discount*</label>
                                    {{ Form::number('discount', old('discount'), ['class' => 'form-control', 'step'=>'.02']) }}
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Min Order Amount*</label> <br>
                                    {{ Form::number('min_order_amount', old('min_order_amount'), ['class' => 'form-control', 'step'=>'.02']) }}
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Max Discount Amount*</label> <br>
                                    {{ Form::number('max_discount_amount', old('max_discount_amount'), ['class' => 'form-control','step'=>'.02']) }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Description*</label>
                                    {{ Form::textarea('description', old('description'), ['class' => 'form-control', 'rows' => 4, 'cols' => 40]) }}
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Expired At*</label>
                                    {{ Form::date('expired_at', old('expired_at'), ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Number Of Time Used*</label> <br>
                                    {{ Form::number('number_of_time_used', old('number_of_time_used'), ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Is Active*</label> &nbsp
                                    {{ Form::checkbox('is_active', 1, false , old('is_active') , ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.card-body -->

                    <!-- .card-footer -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    <!-- /.card-footer -->
                    {{ Form::close() }}


                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection

