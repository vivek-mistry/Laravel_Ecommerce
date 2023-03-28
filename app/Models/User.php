<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * Set default order by
     *
     * @return void
     */
    protected static function booted()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Set Increment id to false
     *
     * @var boolean
     */
    public $incrementing = true;

    /**
     * Load user_roles relation
     *
     * @return BelongsToMany
     */
    public function user_roles(): BelongsToMany
    {
        return $this->belongsToMany(UserRoles::class, 'user_role_mappings', 'user_id','user_role_id')->whereNull('user_role_mappings.deleted_at')
            ->orderBy('user_role_mappings.created_at', 'DESC');
    }

    /**
     * laod user addresses relation
     *
     * @return HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }
}
