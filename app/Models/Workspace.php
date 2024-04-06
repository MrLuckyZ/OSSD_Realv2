<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;

    public function userCreate()
    {
        return $this->belongsTo(User::class,'user_create');
    }

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
}
