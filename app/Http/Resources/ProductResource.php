<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */


/**
 * @OA\Schema(
 *     schema="ProductResource",
 *     type="object",
 *     title="Product Resource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="iPhone 15 Pro Max"),
 *     @OA\Property(property="description", type="string", example="Flagship của Apple"),
 *     @OA\Property(property="price", type="number", format="float", example=2999.99),
 *     @OA\Property(property="category_id", type="integer", example=2),
 *     @OA\Property(property="image_url", type="string", example="assets/images/iphone15.jpg"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

 


    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price, 
            'stock' => $this->stock,
            'final_price' => $this->final_price, 
            'is_discounted' => $this->final_price < $this->price, 
            'category_id' => $this->category_id,
            'image_url' => asset($this->image_url),
        ];
    }
}
