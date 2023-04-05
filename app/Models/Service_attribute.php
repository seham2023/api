<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_attribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'value_id',
        'attribute_id',
        'service_id'

    ];
}
