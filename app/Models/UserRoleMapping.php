<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRoleMapping extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Set Table name
     *
     * @var string
     */
    protected $table = 'user_role_mappings';

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
        'user_role_id',
        'user_id'
    ];
}
