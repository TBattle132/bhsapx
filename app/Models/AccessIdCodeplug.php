<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AccessIdCodeplug extends Pivot
{
    protected $table = 'access_id_codeplug';
    protected $casts = ['permissions' => 'array'];
}
