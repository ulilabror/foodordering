<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'is_available',
        'image_path',
        'category_id'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

     // Relasi: satu menu dimiliki oleh satu kategori
     public function category()
     {
         return $this->belongsTo(Category::class);
     }
}