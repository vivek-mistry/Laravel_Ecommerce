@extends('components.front-end.front-end-layout')

@section('contents')
    <div class="container">
        <div class="row my-5 py-lg-5">
            <div class="col-md-6">
                <h3 class="font-32 font-bold text-uppercase mb-4 text-center">Sign In</h3>
                {{ Form::open(['url' => URL::to('authenticate'), 'method' => 'Post', 'class' => 'common_form']) }}
                <div class="input_wraper mb-3">
                    <label>Email</label>
                    {{ Form::email('email', old('email'), []) }}
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input_wraper mb-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <label>Password</label>
                        <span class="">Case sensitive</span>
                    </div>
                    {{ Form::password('password', []) }}
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="remember d-flex">
                    <input type="radio" class="mx-2 ml-0" name="makegift" id="gift">
                    <label for="gift">
                        <p>Keep me signed in. What's New?
                            <span class="d-block font-14">Only check this box if on a personal device</span>
                        </p>
                    </label>
                </div>
                @if (Session::has('message_error'))
                    <div class="alert alert-danger">{!! session('message_error') !!}</div>
                @endif
                <button type="submit"
                    class="site_button font-bold font-18 py-3 text-uppercase d-block my-4 text-center w-100">Sign
                    In</button>
                <div class="text-center">
                    <a href="{{ url('forget-password') }}" class="text-decoration-underline">Forgot Your Password?</a>
                </div>
                {{ Form::close() }}
            </div>
            <div class="col-md-6 text-center pt-lg-5">
                <h3 class="font-28 font-bold text-uppercase text-center mt-lg-4 mb-5">No account yet?</h3>
                <a href="{{ url('register') }}" class="site_button font-bold font-18 py-3 text-uppercase d-block my-4 text-center">Create
                    Account</a>
                <div class="text-center pt-lg-4">
                    <p class="font-18 font-bold text-uppercase mb-3">Continue with</p>
                    <ul class="d-flex justify-content-center align-items-center mb-5">
                        <li><a href="#"><img src="assets/icons/Google.svg" width="40px" height="40px"></a></li>
                        <li><a href="#" class="mx-3"><img src="assets/icons/Facebook.svg" width="40px"
                                    height="40px"></a></li>
                        <li><a href="#"><img src="assets/icons/Instagram.svg" width="40px" height="40px"></a></li>
                        <li class="mx-3"><a href="#"><img src="assets/icons/linkedin.svg" width="40px"
                                    height="40px"></a></li>
                        <li><a href="#"><img src="assets/icons/Twitter.svg" width="40px" height="40px"></a></li>
                    </ul>
                    <a href="#" class="font-14 text-decoration-underline">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </div>
@endsection
