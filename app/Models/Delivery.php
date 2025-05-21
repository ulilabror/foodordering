<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'courier_id',
        'delivery_fee',
        'delivery_status',
        'address',
        'latitude',
        'longitude',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    public function scopeVisibleToCourier($query, $user)
    {
        if (!$user) {
            return $query->whereRaw('1 = 0'); // Jangan tampilkan data jika tidak ada user
        }

        if ($user->courier) {
            // Cek apakah kurir memiliki pengiriman aktif
            $hasActiveDelivery = self::where('courier_id', $user->courier->id)
                ->whereIn('delivery_status', ['assigned', 'on_delivery'])
                ->exists();

            if ($hasActiveDelivery) {
                // Query pengiriman aktif untuk kurir
                $query->where('courier_id', $user->courier->id)
                    ->whereNotIn('delivery_status', ['delivered'])
                    ->orWhereIn('delivery_status', ['assigned', 'on_delivery']);
            } else {
                // Query pengiriman yang belum diambil
                $query->whereNull('courier_id')
                    ->whereNull('delivery_status')
                    ->orWhereNotIn('delivery_status', ['on_delivery', 'delivered']);
            }
        } else {
            // Query untuk pengguna yang bukan kurir
            $query->whereNull('courier_id')
                ->whereNull('delivery_status')
                ->orWhereNotIn('delivery_status', ['on_delivery', 'delivered']);
        }

        return $query;
    }
}