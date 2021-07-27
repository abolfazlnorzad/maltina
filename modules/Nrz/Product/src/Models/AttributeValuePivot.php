<?php


namespace Nrz\Product\Models;


use Illuminate\Database\Eloquent\Relations\Pivot;

class AttributeValuePivot extends Pivot
{

    public function value()
    {
        return $this->belongsTo(AttributeValue::class,"value_id","id");
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class,"attribute_id","id");
    }



}
