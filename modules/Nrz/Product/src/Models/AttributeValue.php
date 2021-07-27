<?php

namespace Nrz\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{


    use HasFactory;

    protected $fillable=[
        "value"
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
