<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccessId extends Model
{
    protected $table = 'access_ids';

    // Match your real columns
    protected $fillable = [
        'account_id',
        'user_id',
        'codeplug_id',
        'access_id',   // human label/code shown to user (unique)
        'id_value',    // the actual Radio ID value (unique)
        'label',
        'token',       // secret/token (unique)
        'active',
        'tx_allowed',
        'expires_at',
        'notes',
    ];

    protected $casts = [
        'active'     => 'bool',
        'tx_allowed' => 'bool',
        'expires_at' => 'datetime',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function codeplug(): BelongsTo
    {
        return $this->belongsTo(Codeplug::class);
    }
}
