<?php

namespace App\Repositories\Interfaces;

interface OtpVerificationRepositoryInterface
{
    public function createOrUpdate(array $data, string $id = null);

    public function setPreviousOtpExpired(string $request_for, string $user_id, array $data);

    public function fetchLatestOtp(string $user_id, string $request_for);

    public function getRecordByField(string $field_name, string $value);
}
