<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderColorItemsResource extends JsonResource
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
           // 'color' => new ColorResource($this->whenLoaded('color')),
            'order_item_id' => $this->order_item_id,
            'color_id' => $this->color_id,
        ];
    }
}
