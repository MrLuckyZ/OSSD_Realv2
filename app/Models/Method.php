<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
    use HasFactory;
    private $type;
    private $route;
    private $request_header = [];
    private $parameter = [];
    private $request_body = [];
    private $response = [];


}
