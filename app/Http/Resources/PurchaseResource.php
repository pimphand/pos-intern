<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
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
            'supplier_id'      => $this->supplier_id,
            'qty'                => $this->qty,
            'purchase_price'     => $this->purchase_price,
            'additional_costs'   => $this->additional_costs,
            'total'         => $this->total,
            'receipt'       => $this->receipt,
            'created_at'    => $this->created_at,
            'update_at'     => $this->updated_at
        ];
    }
}
