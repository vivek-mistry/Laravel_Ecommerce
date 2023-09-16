<?php

namespace App\Repositories\Respository;

use App\Models\OtpVerification;
use App\Repositories\Interfaces\OtpVerificationRepositoryInterface;

class OtpVerificationRepository implements OtpVerificationRepositoryInterface
{
    /**
     * Create or update
     *
     * @param array $data
     * @param string|null $id
     * @return OtpVerification
     */
    public function createOrUpdate(array $data, string $id = null): OtpVerification
    {
        if (!isset($id)) {
            $otp_verification = new OtpVerification($data);
        } else {
            $otp_verification = OtpVerification::find($id);

            foreach ($data as $key => $value) {
                $otp_verification->$key = $value;
            }
        }
        $otp_verification->save();
        return $otp_verification;
    }

    public function setPreviousOtpExpired(string $request_for, string $user_id, array $data)
    {
        return OtpVerification::where('request_for', '=', $request_for)
            ->where('status', '=', OtpVerification::STATUS_PENDING)
            ->where('user_id', '=', $user_id)
            ->update($data);
    }

    /**
     * Fetch latest OTP
     *
     * @param string $user_id
     * @param string $request_for
     * @return void
     */
    public function fetchLatestOtp(string $user_id, string $request_for)
    {
        $otp_verification = OtpVerification::where('user_id', '=', $user_id);

        $otp_verification->where('request_for', '=', $request_for)
            ->where('status', '=', OtpVerification::STATUS_PENDING);


        return $otp_verification->first();
    }

    /**
     * Get Record By Field & value
     *
     * @param string $field_name
     * @param string $value
     * @return void
     */
    public function getRecordByField(string $field_name, string $value)
    {
        $otp_verification = OtpVerification::where($field_name, '=', $value)->first();

        return $otp_verification;
    }
}
