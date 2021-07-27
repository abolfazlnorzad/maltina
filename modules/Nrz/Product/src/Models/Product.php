<?php

namespace Nrz\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nrz\Order\Models\Order;
use Nrz\Order\Models\OrderProductValue;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        "name", "price"
    ];




    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)
            ->using(AttributeValuePivot::class)->withPivot(['value_id', "attribute_id"]);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->using(OrderProductValue::class)
            ->withPivot('value_id');
    }
}
