<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessId extends Model
{
    use HasFactory;

    protected $table = 'access_ids';

    protected $fillable = [
        'account_id',
        'codeplug_id',
        'user_id',
        'access_id',
        'active',
        'label',
        'token',
        'tx_allowed',
        'expires_at',
        'notes',
        'id_value',
    ];

    protected $casts = [
        'active'     => 'boolean',
        'tx_allowed' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function codeplug()
    {
        return $this->belongsTo(Codeplug::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
