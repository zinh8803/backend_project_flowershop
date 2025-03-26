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
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'payment_method' => $this->payment_method,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'discount' => $this->discount ? [
                'id' => $this->discount->id,
                'code' => $this->discount->code,
                'type' => $this->discount->type,
                'value' => $this->discount->value,
            ] : null,

            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems'))
          
        ];
    }
}
