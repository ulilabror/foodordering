<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'menu_id',
        'quantity',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    // Boot method to listen for model events
    protected static function boot()
    {
        parent::boot();

        // Update total_price on create, update, or delete
        static::saved(function ($orderItem) {
            $orderItem->order->recalculateTotalPrice();
        });

        static::deleted(function ($orderItem) {
            $orderItem->order->recalculateTotalPrice();
        });
    }
}