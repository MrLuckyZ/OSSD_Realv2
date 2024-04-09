<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request_Header extends Model
{
    use HasFactory;
    private $key;
    private $required;
    private $description;
}

