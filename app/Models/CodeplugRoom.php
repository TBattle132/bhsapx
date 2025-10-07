<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodeplugRoom extends Model
{
    protected $fillable = ['codeplug_id','name','sort'];

    public function codeplug(): BelongsTo
    {
        return $this->belongsTo(Codeplug::class);
    }
}
