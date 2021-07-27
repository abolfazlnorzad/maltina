<?php

namespace Nrz\Product\Repo;

use Nrz\Product\Models\Attribute;
use Nrz\Product\Models\AttributeValue;
use Nrz\Product\Models\Product;

class ProductRepo
{

    public function getAppProduct()
    {
        return Product::query()
            ->latest()
            ->get()
            ->all();
    }

    public function store($name,$price)
    {
        return Product::query()->create([
            "name" => $name,
            "price" => $price,
        ]);
    }

    public function findOrCreateAttributes($name)
    {
      return Attribute::query()->firstOrCreate([
            "name" => $name
        ]);
    }

    public function findOrCreateValue($value,$attribute)
    {
           return  $attribute->values()->firstOrCreate([
                "value" => $value
            ]);
    }

    public function findByName($name)
    {
        return  Product::query()->where("name", $name)->first();
    }

    public function findProductForOrder($product,$order)
    {
        return Product::query()->where("name", $product)->first()
            ?? $order->products[0]->pivot->product;
    }


}
