<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response_body extends Model
{
    use HasFactory;
    protected $fillable = ['key'];
    private $data_type;
    private $description;
}
