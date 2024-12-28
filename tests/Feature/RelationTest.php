<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\SaleDetail;
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
    // Test for relation between product and stock
    public function test_relation_success_product_and_stock()
    {
        // Check if product has relation with stock
        $product = Product::first();
        $stock = $product->stock;
        $this->assertInstanceOf(Stock::class, $stock);

        // Check if stock has relation with product
        $stock = Stock::first();
        $product = $stock->product;
        $this->assertInstanceOf(Product::class, $product);

        // Check if product has one stock
        $product = Product::first();
        $stock = $product->stock();
        $this->assertInstanceOf(HasOne::class, $stock);

        // Check if stock belongs to product
        $stock = Stock::first();
        $product = $stock->product();
        $this->assertInstanceOf(BelongsTo::class, $product);
    }
    public function test_getData_product_and_stock()
    {
        $product = Product::first();
        $stock = $product->stock;

        $this->assertSame($product->id, $stock->product_id);

        $stock = Stock::first();
        $product = $stock->product;
        $this->assertSame($stock->product_id, $product->id);
    }

    public function test_relation_success_sale_and_sale_details()
    {
        $sale = Sale::first();
        $SaleDetail = $sale->sale_detail;
        $this->assertInstanceOf(SaleDetail::class, $SaleDetail);

        $hasOne = $sale->sale_detail();
        $this->assertinstanceOf(HasOne::class, $hasOne);

        $sale_detail = SaleDetail::first();
        $sale = $sale_detail->sale;
        $this->assertInstanceOf(Sale::class, $sale);

        $belongsTo = $sale_detail->sale();
        $this->assertInstanceOf(belongsTo::class, $belongsTo);
    }


    public function test_getData_sale_and_saleDetail()
    {
        $sale = Sale::first();
        $saleDetail = $sale->sale_detail;
        $this->assertSame($sale->id, $saleDetail->sale_id);

        $saleDetail = SaleDetail::first();
        $sale = $saleDetail->sale;
        $this->assertSame($saleDetail->sale_id, $sale->id);
    }


    // Test for relation between customer and sale details
    public function test_relation_success_customer_and_sale_details()
    {
        // Check if customer has relation with sale
        $customer = Customer::first();
        $sale = $customer->sale;
        $this->assertInstanceOf(Collection::class, $sale);

        // Check if sale has relation with customer
        $sale = Sale::first();
        $customer = $sale->customer;
        $this->assertInstanceOf(Customer::class, $customer);

        // Check if customer has many sale 
        $customer = Customer::first();
        $sale = $customer->sale();
        $this->assertInstanceOf(HasMany::class, $sale);

        // Check if sale detail belongs to customer
        $sale = Sale::first();
        $customer = $sale->customer();
        $this->assertInstanceOf(BelongsTo::class, $customer);
    }

    public function test_getData_customer_and_Sales()
    {
        $customer = Customer::first();
        $saleDetails = $customer->sale;
        if ($saleDetails->count() > 0) {
            $this->assertSame($customer->id, $saleDetails->first()->customer_id);
        }

        $saleDetail = Sale::first();
        $customer = $saleDetail->customer;
        $this->assertSame($saleDetail->customer_id, $customer->id);
    }
}
