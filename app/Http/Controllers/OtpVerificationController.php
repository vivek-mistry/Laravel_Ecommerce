<?php

namespace App\Http\Controllers;

use App\Mail\OtpVerificationMail;
use App\Models\OtpVerification;
use App\Repositories\Interfaces\OtpVerificationRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OtpVerificationController extends Controller
{
    /**
     * @var OtpVerificationRepositoryInterface
     */
    protected $otpVerificationRepository;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    public function __construct(
        OtpVerificationRepositoryInterface $otpVerificationRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
        $this->otpVerificationRepository = $otpVerificationRepository;
    }

    /**
     * Random OTP Generate
     *
     * @return int
     */
    public function generateOtp()
    {
        return rand(1000, 9999);
        // return 1234;
    }

    /**
     * Generate Access Code
     *
     * @return string
     */
    public function generateAccessCode()
    {
        return md5(rand(100000, 999999));
    }

    /**
     * Generate OTP for forget Password
     *
     * @param Request $request
     * @return void
     */
    public function genreateOtpForgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'exists:users,email'
            ]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = $this->userRepository->getUserByField('email', $request->email);

        // set previous OTP expired before generating new
        $update_previou_data = [
            'status' => OtpVerification::STATUS_EXPIRED,
            'expired_dt' => Carbon::now()
        ];
        $this->otpVerificationRepository->setPreviousOtpExpired(OtpVerification::REQUEST_FOR_RESET_PASS, $user->id, $update_previou_data);

        // Generate new otp functionality
        $data = [
            'user_id' => $user->id,
            'otp' => $this->generateOtp(),
            'status' => OtpVerification::STATUS_PENDING,
            'request_for' => OtpVerification::REQUEST_FOR_RESET_PASS
        ];
        $otp_verification = $this->otpVerificationRepository->createOrUpdate($data);

        /**
         * EVENT to send mail to user for OTP
         */
        Mail::to($user->email)->send(new OtpVerificationMail($user, $otp_verification));

        return response()->json([
            'status' => true,
            'message' => 'OTP has been sent',
            'user_id'    => $user->id
        ], 200);
    }

    public function otpVerification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => [
                'required',
            ],
            'request_for' => [
                'required',
                Rule::in([OtpVerification::REQUEST_FOR_RESET_PASS])
            ]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }


        $user_id = $request->user_id;

        // 1. fetch otp done
        $fetch_otp = $this->otpVerificationRepository->fetchLatestOtp($user_id, OtpVerification::REQUEST_FOR_RESET_PASS);
        if (!$fetch_otp) {
            return response()->json([
                'status' => false,
                'message' => 'Please resend the OTP',
            ], 200);
        }

        // 3. match otp (manage failed)
        if ($fetch_otp->otp != $request->otp) {
            // $fetch_otp->failed_dt = Carbon::now();
            // $fetch_otp->status = OtpVerification::STATUS_FAILED;
            // $fetch_otp->save();
            return response()->json([
                'status' => false,
                'message' => 'OTP did not match',
            ], 200);
        }

        // 2. check expired
        $generated_otp_at = new Carbon($fetch_otp->created_at);
        $current = Carbon::now();
        $check_expired = $generated_otp_at->diffInSeconds($current);
        if ($check_expired > 180) {
            $fetch_otp->expired_dt = Carbon::now();
            $fetch_otp->status = OtpVerification::STATUS_EXPIRED;
            $fetch_otp->save();
            return response()->json([
                'status' => false,
                'message' => 'OTP is expired',
            ], 200);
        }

        // 4. completed verify
        $fetch_otp->completed_dt = Carbon::now();
        $fetch_otp->status = OtpVerification::STATUS_COMPLETED;
        $fetch_otp->access_code_dt = Carbon::now();
        $fetch_otp->access_code = $this->generateAccessCode();
        $fetch_otp->save();
        return response()->json([
            'status' => true,
            'message' => 'OTP verified successfully',
            'access_code' => $fetch_otp->access_code
        ], 200);
    }

    /**
     * Reset Password
     *
     * @param Request $request
     * @return void
     */
    public function resetPassword(Request $request){

        $validator = Validator::make($request->all(), [
            'password' => [
                'required'
            ],
            'access_code' => [
                'required',
                Rule::exists('otp_verifications', 'access_code')->where('is_request_complete', null)
            ]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $fetch_otp = $this->otpVerificationRepository->getRecordByField('access_code', $request->access_code);

        $generated_otp_at = new Carbon($fetch_otp->access_code_dt);
        $current = Carbon::now();
        $check_expired = $generated_otp_at->diffInMinutes($current);

        if($check_expired > 5){
            $fetch_otp->is_request_complete = 0;
            $fetch_otp->save();
            return response()->json([
                'status' => false,
                'message' => 'Request is expired',
            ], 200);
        }

        $fetch_otp->is_request_complete = 1;
        $fetch_otp->save();

        /**
         * Update Password
         */
        $data = [
            'password' => Hash::make($request->password)
        ];
        $this->userRepository->createOrUpdate($data, $request->user_id);

        return response()->json([
            'status' => true,
            'message' => 'Successfuly reset the password',
        ], 200);
    }
}
