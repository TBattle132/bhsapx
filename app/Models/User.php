<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'account_id',
        'is_superuser',
    ];

    /**
     * Hidden attributes for arrays/JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_superuser'      => 'boolean',
    ];

    /**
     * Relationships
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Convenience: can this user access the admin area?
     */
    public function canAccessAdmin(): bool
    {
        return (bool) $this->is_superuser;
    }
}
