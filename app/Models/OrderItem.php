<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price','size_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function getFinalPriceAttribute()
    {
        return $this->product->getFinalPriceAttribute();
    }
    public function orderItemColors()
    {
        return $this->hasMany(OrderItemColor::class, 'order_item_id');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'order_item_color', 'order_item_id', 'color_id');
    }
}
