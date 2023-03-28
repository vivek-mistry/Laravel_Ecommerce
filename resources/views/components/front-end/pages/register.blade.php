@extends('components.front-end.front-end-layout')

@section('contents')

<div class="container">
    <div class="row my-5 py-lg-5">
        <div class="col-md-6 offset-md-3">
            <h3 class="font-32 font-bold text-uppercase mb-4 text-center">Create an Account</h3>
            @if(Session::has('message_success'))
                <div class="alert alert-success">{{ Session::get('message_success') }}</div>
            @endif
            {{ Form::open(['url' => URL::to('user-store'),  'method' => 'Post', 'class' => 'common_form']) }}
                <div class="input_wraper mb-3">
                    <label>Full Name</label>
                    {{ Form::text('name', old('name'), []) }}
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input_wraper mb-3">
                    <label>Email</label>
                    {{ Form::email('email', old('email'), []) }}
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input_wraper mb-3">
                    <label>Phone</label>
                    {{ Form::number('phone_number', old('phone_number'), []) }}
                    @error('phone_number')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input_wraper mb-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <label>Password</label>
                        <a href="#" class="text-uppercase">SHow</a>
                    </div>
                    {{ Form::password('password', []) }}
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="site_button font-bold font-18 py-3 text-uppercase d-block my-4 text-center w-100">Create an Account</button>
                <div class="d-flex align-items-center justify-content-center my-4">
                    <span class="mx-4 ml-0 text-uppercase">Continue with</span>
                    <ul class="d-flex align-items-center">
                        <li><a href="#"><img src="assets/icons/fb-black.svg"></a></li>
                        <li class="mx-3"><a href="#"><img src="assets/icons/Twitter-black.svg"></a></li>
                        <li><a href="#"><img src="assets/icons/linkedin-black.svg"></a></li>
                    </ul>
                </div>
                <div class="text-center">
                    <a href="#" class="text-decoration-underline">Terms & Conditions</a>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>


@endsection
