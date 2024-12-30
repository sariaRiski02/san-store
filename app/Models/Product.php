<?php

namespace App\Models;


use App\Models\Stock;
use App\Models\Category;
use App\Models\ProductDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'code_item',
        'description',
        'category_id'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product_detail()
    {
        return $this->hasOne(ProductDetail::class);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }
}
