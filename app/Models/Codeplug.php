<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Codeplug extends Model
{
    use HasFactory;

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

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
