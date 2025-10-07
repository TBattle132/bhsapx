<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $table = 'accounts';

    protected $fillable = [
        'name',
        'notes',
        // add other columns if you later add them to the table
    ];

    public function codeplugs(): HasMany
    {
        return $this->hasMany(Codeplug::class);
    }

    public function accessIds(): HasMany
    {
        return $this->hasMany(AccessId::class);
    }
}
