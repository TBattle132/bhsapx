<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Codeplug extends Model
{
    protected $table = 'codeplugs';

    protected $fillable = [
        'account_id',
        'name',
        'notes',
        'ws_url',
        'auth_mode',
        'simple_key',
        'default_room',
        'default_volume',
        'default_hotkey',
    ];

    protected $casts = [
        'default_volume' => 'integer',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
