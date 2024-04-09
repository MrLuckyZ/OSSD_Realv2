<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Response_body;

class Response extends Model
{
    use HasFactory;
    private $status;
    private $code;
    private $response_body = [];
}
