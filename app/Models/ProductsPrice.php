<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsPrice extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function productsPriceType()
    {
        return $this->belongsTo(ProductsPriceType::class, 'products_price_type_id');
    }
}
