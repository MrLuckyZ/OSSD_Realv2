<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    private $methods = [];
    
    protected $casts = [
        'properties' => 'array'
    ];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function setPropertiesAttribute($value)
    {

        $this->attributes['properties'] = $value;
    }   

    public function getMethods()
    {
        return $this->methods;
    }

    public function setMethods(array $methods)
    {
        $this->methods = $methods;
    }
}

