<?php


namespace Nrz\Order\Models;


use Illuminate\Database\Eloquent\Relations\Pivot;
use Nrz\Product\Models\Attribute;
use Nrz\Product\Models\AttributeValue;
use Nrz\Product\Models\Product;

class OrderProductValue extends Pivot
{

    public function value()
    {
        return $this->belongsTo(AttributeValue::class,"value_id","id");
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class,"attribute_id","id");
    }

    public function product()
    {
        return $this->belongsTo(Product::class,"product_id","id");
    }

}
