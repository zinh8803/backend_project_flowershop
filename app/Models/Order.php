<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'total_price', 'discount_id', 'status','name','email', 'address', 'phone_number','created_at','updated_at' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'order_items')->withPivot('quantity', 'price');
    }
   public function orderItems()
{
    return $this->hasMany(OrderItem::class, 'order_id');
}

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
    public function getFinalTotalPriceAttribute()
    {
    $total = $this->orderItems->sum(function ($item) {
        return $item->final_price * $item->quantity;
    });

    if ($this->discount) {
        $total *= (1 - $this->discount->percentage / 100);
    }

    return round($total, 2);
    }
}
