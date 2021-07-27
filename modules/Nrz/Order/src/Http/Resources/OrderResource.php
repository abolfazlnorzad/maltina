<?php

namespace Nrz\Order\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        dd($request->all());
//        return parent::toArray($request);
//        dd($this->resource->products[0]->pivot->attribute);

        return [
            "user" => $this->resource->user->name,
            "product" => $this->resource->products[0]->pivot->product->name,
            "attribute"=>$this->resource->products[0]->pivot->attribute->name,
            "value"=>$this->resource->products[0]->pivot->value->value,
            "status" => $this->status,
            "price" => $this->price,
            "consume_location" => $this->consume_location,
            "quantity" =>$this->quantity
        ];
    }
}
