<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SellResource extends JsonResource
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
            'customer_name' => $this->customer->name,
            'customer_address' => $this->customer->address,
            'customer_phone' => $this->customer->phone,
            'products' => json_decode($this->products),
            'payments' => json_decode($this->payments),
            'date' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
