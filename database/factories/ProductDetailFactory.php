<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product_detail>
 */
class ProductDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idProduct = Product::pluck('id')->toArray();
        $product_id = ProductDetail::pluck('product_id')->toArray();
        $diff = array_diff($idProduct, $product_id);
        $rand_id = array_rand($diff);
        $id = $diff[$rand_id];

        return [
            'product_id' => $id,
            'base_unit' => fake()->randomElement(['kg', 'gr', 'lusin', 'ml', 'unit', 'liter']),
            'factor_base_unit' => fake()->randomFloat(2, 1, 1000),
            'unit_price' => fake()->randomFloat(2, 1, 1000),
            'base_price' => fake()->randomFloat(2, 1, 1000),
            'discount' => fake()->randomFloat(2, 1, 100),

        ];
    }
}
