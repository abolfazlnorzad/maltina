<?php

namespace Nrz\Product\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

//        $attrs = [];
//        foreach ($this->resource->attributes as $attr) {
//            $attrs[$attr->name] = $attr;
//        }
//        dd($this->attributes[0]->pivot->attribute->name);
        return [
            "name" => $this->name,
            "price" => $this->price,
//            "options" => AttributeResource::collection($attrs),
            "attribute" =>$this->attributes[0]->pivot->attribute->name,
            "value" =>$this->attributes->map(function ($attr){
                return $attr->pivot->value->value;
            }),
        ];
    }
}
