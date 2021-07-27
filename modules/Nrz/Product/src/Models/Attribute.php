<?php

namespace Nrz\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->using(AttributeValuePivot::class)->withPivot(['value_id',"attribute_id"]);
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
