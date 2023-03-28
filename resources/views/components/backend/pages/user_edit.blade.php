@extends('components.backend.layout')

@section('contents')
<!-- Content Header (Page header) -->
@php
$breadcrumb = '<li class="breadcrumb-item"><a href="#">Dashboard</a></li>';
$breadcrumb .= '<li class="breadcrumb-item"><a href="#">User</a></li>';
$breadcrumb .= '<li class="breadcrumb-item active">Update</li>';
@endphp
<x-backend-breadcrumb title="User" breadcrumb="{{$breadcrumb}}" />
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <!-- .card-header -->
                    <div class="card-header">
                        @include('components.backend.alert.validation-error')
                    </div>
                    <!-- /.card-header -->

                    {{ Form::open(['url' => URL::to('backend/user/update/'.$user->id),  'method' => 'Put']) }}
                    <!-- .card-body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Full Name*</label>
                                    {{ Form::text('name', $user->name, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Phone Number*</label>
                                    {{ Form::number('phone_number', $user->phone_number, ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Email*</label>
                                    {{ Form::email('email', $user->email, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Password*</label>
                                    {{ Form::password('password', ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <!-- .card-footer -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
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

