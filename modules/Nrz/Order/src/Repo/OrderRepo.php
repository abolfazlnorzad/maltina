<?php

namespace Nrz\Order\Repo;

use Nrz\Order\Models\Order;
use Nrz\Product\Models\Attribute;
use Nrz\Product\Models\AttributeValue;

class OrderRepo
{

    public function getAllOrder()
    {
        return Order::query()
            ->where("status","!=",Order::STATUS_CANCELED)
            ->latest()->paginate(20);
    }

    public function getAllUserOrder()
    {
        return Order::query()
            ->where("status","!=",Order::STATUS_CANCELED)
            ->where("user_id", auth()->id())->latest()->paginate(20);
    }

    public function store($product, $quantity, $consumeLocation)
    {
        return Order::query()->create([
            "user_id" => auth()->id(),
            "consume_location" => $consumeLocation,
            "price" => $product->price * $quantity,
            "quantity" => $quantity
        ]);
    }

    public function findAttributeByName($name)
    {
        return Attribute::query()->where("name", $name)->first();
    }

    public function findValueByName($value)
    {
        return AttributeValue::query()->where("value", $value)->first();
    }

    public function setAttributeAndValue($order, $product, $attr, $value)
    {
        return $order->products()->attach($product->id, [
            "attribute_id" => $attr->id,
            "value_id" => $value->id,
        ]);
    }

    public function findById($order)
    {
        return Order::query()->find($order);
    }

    public function updateStatus($order, $status = "canceled")
    {
        return $order->update([
            "status" => $status
        ]);
    }

    public function update($order,$consume_location,$quantity,$product)
    {
        return $order->update([
            "consume_location" => $consume_location ?? $order->consume_location,
            "price" => ($product->price * ($quantity ?? $order->quantity)),
            "quantity" => ($quantity ?? $order->quantity)
        ]);
    }

    public function findAttributesByName($attr)
    {
        return Attribute::query()->where("name", $attr)->first();
    }

    public function findValuesByName($val)
    {
        return AttributeValue::query()->where("value", $val)->first();
    }

    public function syncAttrAndValForOrderUpdate($order,$product,$attr,$value)
    {
        return   $order->products()->sync([
            1 => [
                "product_id" => $product->id,
                "attribute_id" => $attr->id,
                "value_id" => $value->id,
            ]
        ]);
    }

}
