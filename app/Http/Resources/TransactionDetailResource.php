<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionDetailResource extends JsonResource
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
            'transaction_id'   => $this->transaction_id,
            'products_id'   => $this->products_id,
            'no_invoice'    => $this->no_invoice,
            'qty'           => $this->qty,
            'total'         => $this->total,
            'created_at'    => $this->created_at,
            'update_at'     => $this->updated_at
        ];
    }
}
