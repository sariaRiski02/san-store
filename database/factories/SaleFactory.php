<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {


        return [
            'user_id' => User::inrandomOrder()->first()->id,
            'customer_id' => Customer::inrandomOrder()->first()->id,
            'invoice_number' => "SNTY-" . fake()->date() . "-" . fake()->randomNumber(),
            'payment_method' => fake()->randomElement(['Tunai', 'Kartu Kredit', 'Transfer Bank', "E-wallet"]),
            'payment_status'  => fake()->randomElement([
                'paid',
                'unpaid',
                'panding'
            ]),
            'balance_due' => 0,
            'total_amount' => fake()->randomFloat(2, 100, 10000)

        ];
    }
}
