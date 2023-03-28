@extends('components.backend.layout')

@section('contents')
<!-- Content Header (Page header) -->
@php
$breadcrumb = '<li class="breadcrumb-item"><a href="#">Dashboard</a></li>';
$breadcrumb .= '<li class="breadcrumb-item active">Order</li>';
@endphp
<x-backend-breadcrumb title="Order" breadcrumb="{{$breadcrumb}}" />
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
                        {{-- <a href="{{ URL::to('backend/user/create') }}" class="btn btn-primary btn-sm float-right">+ Create User</a> --}}
                    </div>
                    <!-- /.card-header -->

                    <!-- .card-body -->
                    <div class="card-body">
                        <table id="order-list" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Order At</th>
                                    {{-- <th>Action</th> --}}
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
<script src="{{ asset('backend_assets/dist/js/order_list.js') }}"></script>
@endsection
