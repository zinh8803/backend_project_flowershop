<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price','stock', 'category_id', 'image_url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price');
    }
    public function discount()
    {
        return $this->hasOne(ProductDiscount::class, 'product_id');
    }
    public function employees()
    {   
    return $this->belongsToMany(Employee::class, 'employee_product');
    }
    public function sizes()
    {
    return $this->belongsToMany(Size::class, 'product_size');
    }

    public function colors()
    {
    return $this->belongsToMany(Color::class, 'color_product');
    }
    public function getFinalPriceAttribute()
    {
        $currentDate = now();

        $discount = $this->discount()
            ->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->first();

        if ($discount) {
            return $this->price * (1 - $discount->percentage / 100);
        }

        return $this->price; 
    }
}
