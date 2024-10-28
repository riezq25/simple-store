<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $purchasePrice = fake()
            ->randomFloat(2, 10, 10000);
        $salePrice = (rand(1, 10) * $purchasePrice) + $purchasePrice;

        return [
            'product_code'  => fake()
                ->unique()
                ->bothify('?????-#####'),
            'product_name'  => fake()
                ->sentence(rand(1, 3)),
            'category_id'   => Category::factory(),
            'purchase_price'    => fake()
                ->randomFloat(2, 10, 10000),
            'sale_price'    => $salePrice,
            'stock_quantity'    => rand(1, 100),
        ];
    }
}
