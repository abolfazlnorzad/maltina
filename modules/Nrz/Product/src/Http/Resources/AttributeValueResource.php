<?php

namespace Nrz\Product\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributeValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        dd($this->attribute);
//        return parent::toArray($request);

        return [
            $this->value
        ];
    }
}
