@extends('components.front-end.front-end-layout')

@section('contents')
    <div class="container my-5">
        <div class="row py-5">

            <div class="col-md-6 px-lg-4 pr-0" id="forget_password_div">
                <h3 class="font-28 font-bold mb-4">Forget Password</h3>
                {{ Form::open(['url' => URL::to('otp-verification/generate'), 'id' => 'form-forget-password', 'method' => 'Post', 'class' => 'common_form edit_information_form']) }}
                <div class="check_input_wrap mb-5">
                    <input type="email" class="form-control" name="email">
                    <label>Email<span class="text-danger">*</span></label>

                </div>
                <button type="submit" class="font-bold font-16 site_button">Submit</button>
                {{ Form::close() }}
            </div>
            <div class="col-md-6 px-lg-4 pr-0" id="otp_verification_div">
                <h3 class="font-28 font-bold mb-4">Otp Verification</h3>
                {{ Form::open(['url' => URL::to('otp-verification/verify'), 'id' => 'form-otp-verification', 'method' => 'Post', 'class' => 'common_form edit_information_form']) }}
                <div class="check_input_wrap mb-5">
                    <input type="number" class="form-control" name="otp" id="otp">
                    <label>OTP<span class="text-danger">*</span></label>
                    <span>This OTP is expired in 60 seconds</span>

                </div>
                <button type="submit" class="font-bold font-16 site_button">Submit</button>
                {{ Form::close() }}
            </div>
            <div class="col-md-6 px-lg-4 pr-0" id="reset_password_div">
                <h3 class="font-28 font-bold mb-4">Reset Password</h3>
                {{ Form::open(['url' => URL::to('reset-password'), 'id' => 'form-reset-password', 'method' => 'Post', 'class' => 'common_form edit_information_form']) }}
                <div class="check_input_wrap mb-5">
                    <input type="password" class="form-control" name="password" id="password">
                    <label>Password<span class="text-danger">*</span></label>
                </div>
                <button type="submit" class="font-bold font-16 site_button">Submit</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#otp_verification_div").hide();
        $("#reset_password_div").hide();
        const request_for = 'reset_password';
        var user_id = "";
        var access_code = "";
        $("#form-forget-password").submit(function(event) {
            event.preventDefault();
            let end_point = $(this).attr('action');
            var post_data = $(this).serialize();
            loadPageLoader();
            $.ajax({
                url: end_point,
                type: "POST",
                data: post_data,
                dataType: 'json',
                content: this,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    removePageLoader();
                    openSnackBar(response.message);
                    if (response.status) {
                        $("#forget_password_div").hide();
                        $("#otp_verification_div").show();
                        user_id = response.user_id;
                    }
                }
            });
        });
        $("#form-otp-verification").submit(function(event) {
            event.preventDefault();
            let end_point = $(this).attr('action');
            var post_data = {
                request_for: request_for,
                user_id: user_id,
                otp: $("#otp").val()
            };
            loadPageLoader();

            $.ajax({
                url: end_point,
                type: "POST",
                data: post_data,
                dataType: 'json',
                content: this,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    removePageLoader();
                    openSnackBar(response.message);
                    if (response.status) {
                        $("#otp_verification_div").hide();
                        $("#reset_password_div").show();
                        access_code = response.access_code;
                    }
                }
            });
        });
        $("#form-reset-password").submit(function(event) {
            event.preventDefault();
            let end_point = $(this).attr('action');
            var post_data = {
                access_code: access_code,
                password: $("#password").val(),
                user_id: user_id,
            };
            loadPageLoader();
            $.ajax({
                url: end_point,
                type: "POST",
                data: post_data,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    removePageLoader();
                    openSnackBar(response.message);
                    if (response.status) {
                        window.location.href = "sign-in"
                    }
                }
            });
        });
    </script>
@endsection
