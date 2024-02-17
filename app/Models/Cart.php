<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;

    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
