<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory,HasApiTokens, Notifiable;
    protected $fillable = ['name','password', 'email', 'phone_number', 'address','position_id'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'password' => 'hashed',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    
    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'employee_category');
    }
    public function products()
    {
        return $this->hasMany(Product::class,'employee_product');
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
