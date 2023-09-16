@extends('components.backend.layout')

@section('contents')
<!-- Content Header (Page header) -->
@php
$breadcrumb = '<li class="breadcrumb-item"><a href="#">Dashboard</a></li>';
$breadcrumb .= '<li class="breadcrumb-item active">Coupon</li>';
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
                        <a href="{{ URL::to('backend/coupon/create') }}" class="btn btn-primary btn-sm float-right">+ Create Coupon</a>
                    </div>
                    <!-- /.card-header -->

                    <!-- .card-body -->
                    <div class="card-body">
                        <table id="coupon-list" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Coupon Code</th>
                                    <th>Type</th>
                                    
                                    <th>Discount (Discount Type)</th>
                                    <th>Min Order Amount</th>
                                    <th>Max Discount Amount</th>
                                    <th>No of Time Used</th>
                                    <th>Expired At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection

@section('scripts')
<script src="{{ asset('backend_assets/dist/js/coupon_list.js') }}"></script>
@endsection
