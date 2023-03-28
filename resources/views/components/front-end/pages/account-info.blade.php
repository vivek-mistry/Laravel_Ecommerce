@extends('components.front-end.front-end-layout')

@section('contents')
    <div class="container my-5">
        <div class="row py-5">
            @include('components.front-end.common.account-sidebar')
            <div class="col-md-9 px-lg-4 pr-0">
                <h3 class="font-28 font-bold mb-4">Edit Account Information</h3>
                <p class="font-18 font-bold mb-4">Account Information</p>
                @if(Session::has('message_success'))
                    <div class="alert alert-success">{{ Session::get('message_success') }}</div>
                @endif
                {{ Form::open(['url' => URL::to('update-account-info/' . auth()->user()->id), 'method' => 'Post', 'class' => 'common_form edit_information_form']) }}
                <div class="check_input_wrap mb-5">
                    <input type="text" class="form-control" name="name" required="required" value="{{ $user->name }}">
                    <label> Name <span class="text-danger">*</span></label>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="check_input_wrap mb-5">
                    <input type="email" class="form-control" name="email" required="required"
                        value="{{ $user->email }}">
                    <label> Email <span class="text-danger">*</span></label>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="check_input_wrap mb-5">
                    <input type="number" class="form-control" name="phone_number" required="required"
                        value="{{ $user->phone_number }}">
                    <label> Phone Number <span class="text-danger">*</span></label>
                    @error('phone_number')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="remember d-flex align-items-center mb-4">
                        <input type="radio" name="" id="email">
                        <label for="email">
                            <p class="set_as font-14 mx-2 mr-0">Change Email</p>
                        </label>
                    </div>
                    <div class="remember d-flex align-items-center mb-4">
                        <input type="radio" name="" id="pass">
                        <label for="pass">
                            <p class="set_as font-14 mx-2 mr-0">Change Password</p>
                        </label>
                    </div>
                    <div class="remember d-flex align-items-center mb-5">
                        <input type="radio" name="" id="remote">
                        <label for="remote">
                            <p class="set_as font-14 mx-2 mr-0">Allow remote shopping assistance ?</p>
                        </label>
                    </div>
                <button type="submit" class="font-bold font-16 site_button">SAVE</button>
                {{ Form::close() }}

                {{-- <a href="#" class="font-bold font-16 site_button">SAVE</a> --}}
            </div>
        </div>
    </div>
@endsection
