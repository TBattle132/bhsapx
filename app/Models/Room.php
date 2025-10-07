<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    protected $fillable = ['codeplug_id','name','slug','order'];

    public function codeplug(): BelongsTo {
        return $this->belongsTo(Codeplug::class);
    }
}
