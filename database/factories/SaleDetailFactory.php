<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale_Detail>
 */
class SaleDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {



        $idSales = Sale::pluck('id')->toArray();
        $foreignId_SaleDetail = SaleDetail::pluck('id')->toArray();
        $diff = array_diff($idSales, $foreignId_SaleDetail);
        $id_rand = array_rand($diff);
        $id = $diff[$id_rand];


        return [
            'product_id' => Product::inrandomOrder()->first()->id,
            'sale_id' => $id,
            'quantity_base_unit' => fake()->numberBetween(1, 100),
            'quantity_unit' => fake()->numberBetween(1, 100),
            'price' => fake()
                ->randomFloat(2, 1, 100000),
            'sub_total' => fake()->randomFloat(2, 1, 100000)

        ];
    }
}
