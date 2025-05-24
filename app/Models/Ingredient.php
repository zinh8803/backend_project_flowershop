<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    protected $fillable = [ 'description'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_ingredient');
    }
}
