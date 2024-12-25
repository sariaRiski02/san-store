<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductDetail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelationTest extends TestCase
{

    // Test for relation between category and product
    public function test_relation_success_category_and_product()
    {
        // Check if category has relation with product
        $category = Category::first();
        $product = $category->products;
        $this->assertInstanceOf(Collection::class, $product);

        // check if product has relation with category
        $product = Product::first();
        $category = $product->category;
        $this->assertInstanceOf(Category::class, $category);


        // Check if category has many products
        $category = Category::first();
        $product = $category->products();
        $this->assertInstanceOf(HasMany::class, $product);

        // Check if product belongs to category
        $product = Product::first();
        $category = $product->category();
        $this->assertInstanceOf(BelongsTo::class, $category);
    }
    public function test_getData_product_and_category()
    {
        $product = Product::first();
        $category = $product->category;
        $this->assertSame($product->category_id, $category->id);


        $category = Category::first();
        $product = $category->products;
        if ($product->count() > 0) {
            $this->assertSame($category->id, $product->first()->category_id);
        }
    }


    // Test for relation between product and product detail
    public function test_relation_success_product_and_product_detail()
    {
        // Check if product has relation with product detail
        $product = Product::first();
        $productDetail = $product->product_detail;
        $this->assertInstanceOf(ProductDetail::class, $productDetail);

        // Check if product_detail has relation with product
        $productDetail = ProductDetail::first();
        $product = $productDetail->product;
        $this->assertInstanceOf(Product::class, $product);

        // Check if product has one product detail
        $product = Product::first();
        $productDetail = $product->product_detail();
        $this->assertInstanceOf(HasOne::class, $productDetail);

        // Check if product detail belongs to product
        $productDetail = ProductDetail::first();
        $product = $productDetail->product();
        $this->assertInstanceOf(BelongsTo::class, $product);
    }
    public function test_getData_product_and_productDetail()
    {
        $product = Product::first();
        $productDetail = $product->product_detail;
        $this->assertSame($product->id, $productDetail->product_id);

        $productDetail = ProductDetail::first();
        $product = $productDetail->product;
        $this->assertSame($productDetail->product_id, $product->id);
    }
}
