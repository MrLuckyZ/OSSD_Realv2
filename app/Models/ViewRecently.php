<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewRecently extends Model
{
    protected $fillable = ['user_id', 'viewable_id', 'viewable_type'];
}
