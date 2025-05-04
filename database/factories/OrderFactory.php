<?php
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = \App\Models\Order::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'status' => $this->faker->randomElement(['pending', 'processing', 'delivered', 'cancelled']),
            'payment_method' => $this->faker->randomElement(['COD', 'Transfer', 'QRIS']),
            'total_price' => $this->faker->randomFloat(2, 100, 1000),
            'delivery_address' => $this->faker->address,
        ];
    }
}