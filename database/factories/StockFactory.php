<?php

namespace Database\Factories;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idProduct = Product::pluck('id')->toArray();
        $product_id = Stock::pluck('product_id')->toArray();
        $diff = array_diff($idProduct, $product_id);
        $rand_id = array_rand($diff);
        $id = $diff[$rand_id];
        return [
            'product_id' => $id,
            'quantity_base_unit' => fake()->randomFloat(2, 1, 1000),
            'quantity' => fake()->randomNumber(2),
        ];
    }
}
