<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AccessId extends Model
{
    protected $fillable = ['user_id','access_id','active','label'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function codeplugs(): BelongsToMany
    {
        return $this->belongsToMany(Codeplug::class)
            ->withPivot('permissions')
            ->withTimestamps()
            ->using(AccessIdCodeplug::class);
    }
    public function account() 
    { 
        return $this->belongsTo(Account::class); 
    }

}
