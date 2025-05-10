<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
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
            'code' => $this->code,
            'value' => $this->value,
            'type' => $this->type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'usage_count' => $this->usage_count,
            'usage_limit' => $this->usage_limit,
            'discount_condition' => [
                'min_order_total' => $this->condition->min_order_total,
            ],
        ];
    }
}
