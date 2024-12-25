<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDetail extends Model
{
    /** @use HasFactory<\Database\Factories\ProductDetailFactory> */
    use HasFactory, SoftDeletes;

    public $table = 'product_details';

    protected $fillable = [
        'product_id',
        'base_unit',
        'factor_base_unit',
        'unit_price',
        'base_price',
        'discount'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
