<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'type', 'value','usage_count','usage_limit', 'start_date', 'end_date'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

     public function condition()
    {
        return $this->hasOne(DiscountCondition::class);
    }
    protected static function booted()
    {
    static::addGlobalScope('valid', function (Builder $builder) {
        $builder->where('end_date', '>=', Carbon::now());
    });
}
}
