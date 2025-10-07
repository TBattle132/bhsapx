<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['name','owner_id'];

    public function owner()   { return $this->belongsTo(User::class, 'owner_id'); }
    public function users()   { return $this->hasMany(User::class); } // optional if you attach users later
    public function codeplugs(){ return $this->hasMany(Codeplug::class); }
    public function accessIds(){ return $this->hasMany(AccessId::class); }
}
