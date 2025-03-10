<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'total_price' => $this->total_price,
            'status' => $this->status,

            'discount' => $this->discount ? [
                'id' => $this->discount->id,
                'code' => $this->discount->code,
                'percentage' => $this->discount->percentage,
            ] : null,

            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems'))
          
        ];
    }
}
