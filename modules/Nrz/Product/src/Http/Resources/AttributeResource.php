<?php

namespace Nrz\Product\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Nrz\Product\Models\Attribute;

class AttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        $attribute = Attribute::query()->where("id", $this->resource)->first();
//        dd($this->resource->values);
        return [
           'values' => AttributeValueResource::collection($this->values)
        ];
    }

}
