<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'payment_method',
        'total_price',
        'delivery_address',
    ];

    public static function boot()
    {
        parent::boot();

        // Event listener for when an Order is created
        static::created(function ($order) {
            // Automatically create a Delivery for the created Order
            $order->delivery()->create([
                'courier_id' => null, // Set to null or assign a default courier if needed
                'delivery_fee' => 0, // Default delivery fee, adjust as needed
                'delivery_status' => null, // Default status
            ]);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    public function recalculateTotalPrice()
    {
        $this->update([
            'total_price' => $this->orderItems->sum(fn($item) => $item->price * $item->quantity),
        ]);
    }
}