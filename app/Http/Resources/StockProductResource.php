<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StockProductResource extends JsonResource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'stock'         => $this->stock,
            'purchase_price'    => $this->purchase_price,
            'selling_price'     => $this->selling_price,
            'margin'        => $this->margin,
            'category_id'   => $this->category_id,
            'created_at'    => $this->created_at,
            'update_at'     => $this->updated_at
        ];
    }
}
