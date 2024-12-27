<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\SaleDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    /** @use HasFactory<\Database\Factories\SaleFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'invoice_number',
        'payment_method',
        'payment_status',
        'balance_due',
        'total_amount',
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sale_detail()
    {
        return $this->hasOne(SaleDetail::class);
    }
}
