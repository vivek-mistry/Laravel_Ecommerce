@extends('components.front-end.front-end-layout')

@section('contents')
    <div class="container my-5">
        <div class="row py-5">
            @include('components.front-end.common.account-sidebar')
            <div class="col-md-9 px-lg-4 pr-0">
                <h3 class="font-28 font-bold mb-4">Change Password</h3>
                {{ Form::open(['url' => URL::to('change-password'),  'method' => 'Post', 'class' => 'common_form edit_information_form']) }}
                <div class="check_input_wrap mb-5">
                    <input type="password" class="form-control" name="old_password" >
                    <label>Old Password<span class="text-danger">*</span></label>
                    @error('old_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="check_input_wrap mb-5">
                    <input type="password" class="form-control" name="new_password" >
                    <label>New Password<span class="text-danger">*</span></label>
                    @error('new_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="check_input_wrap mb-5">
                    <input type="password" class="form-control" name="confirm_password" >
                    <label>Confirm Password<span class="text-danger">*</span></label>
                    @error('confirm_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="font-bold font-16 site_button">Change Password</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
