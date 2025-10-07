<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Codeplug extends Model
{
    protected $fillable = [
        'name','ws_url','auth_mode','simple_key','default_room','default_volume','default_hotkey'
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(CodeplugRoom::class)->orderBy('sort');
    }

    public function accessIds(): BelongsToMany
    {
        return $this->belongsToMany(AccessId::class)
            ->withPivot('permissions')
            ->withTimestamps()
            ->using(AccessIdCodeplug::class);
    }
    public function account() 
    {
         return $this->belongsTo(Account::class); 
    }

}
