@extends('components.backend.layout')

@section('contents')
<!-- Content Header (Page header) -->
@php
$breadcrumb = '<li class="breadcrumb-item"><a href="#">Dashboard</a></li>';
$breadcrumb .= '<li class="breadcrumb-item">Category</li>';
@endphp
<x-backend-breadcrumb title="Category" breadcrumb="{{$breadcrumb}}" />
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

                   
                    <!-- .card-body -->
                    <div class="card-body">
                        {{ $dataTable->table() }}
                        
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
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection