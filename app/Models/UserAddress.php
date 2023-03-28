<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    /**
     * Set Table name
     *
     * @var string
     */
    protected $table = 'user_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone_number',
        'address',
        'pin_code',
        'city',
        'state',
        'is_default'
    ];



}
