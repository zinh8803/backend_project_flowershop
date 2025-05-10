<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCondition extends Model
{
    use HasFactory;
    protected $fillable = ['discount_id', 'min_order_total'];
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
