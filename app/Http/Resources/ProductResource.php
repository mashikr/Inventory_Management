<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'product_code' => $this->product_code,
            'buying_price' => $this->buying_price,
            'selling_price' => $this->selling_price,
            'buying_date' => $this->buying_date,
            'product_quantity' => $this->product_quantity,
            'image' => $this->image,
            'category' => empty($this->category->category)?null:$this->category->category,
            'supplier' => $this->supplier->name,
        ];
    }
}
