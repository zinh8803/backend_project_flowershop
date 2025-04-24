<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemColor extends Model
{
    use HasFactory;
    protected $table = 'order_item_color';
    protected $fillable = ['order_item_id', 'color_id'];

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
}
