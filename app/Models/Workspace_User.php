<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace_User extends Model
{
    use HasFactory;
    protected $table = 'workspace__users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'workspace_id',
        'user_id'
    ];
}
