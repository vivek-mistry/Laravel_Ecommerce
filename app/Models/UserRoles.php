<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRoles extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Constants for Roles
     */
    const USER_ROLE_ADMIN = 'Admin';
    const USER_ROLE_USER = 'User';

    /**
     * Set Table name
     *
     * @var string
     */
    protected $table = 'user_roles';

    /**
     * Set Increment id to false
     *
     * @var boolean
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'role_name'
    ];
}
