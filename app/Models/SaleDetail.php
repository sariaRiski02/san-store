<?php

namespace App\Models;


use App\Models\Sale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleDetail extends Model
{
    /** @use HasFactory<\Database\Factories\SaleDetailFactory> */
    use HasFactory;

    public $table = 'sale_details';

    protected $fillable = [
        'product_id',
        'sale_id',
        'quantity_base_unit',
        'quantity_unit',
        'sub_total',
    ];


    public function Sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
