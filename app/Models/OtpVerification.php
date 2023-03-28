<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OtpVerification extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Status constant
     */
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_EXPIRED = 'expired';

    /**
     * Requested for
     */
    const REQUEST_FOR_RESET_PASS = 'reset_password';


    /**
     * Set default order by
     *
     * @return void
     */
    protected static function booted() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    /**
     * Set Table name
     *
     * @var string
     */
    protected $table = 'otp_verifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'email', 'mobile_no',
        'request_for', 'otp', 'failed_dt', 'completed_dt', 'expired_dt', 'access_code', 'access_code_dt', 'status', 'is_request_complete', 'created_at'
    ];

}
