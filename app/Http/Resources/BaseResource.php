<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->status ?? 200,
            'message' => $this->message ?? 'Success',
            'data' => $this->resource ?? null,
            'errors' => $this->errors ?? null,
        ];
    }
}
