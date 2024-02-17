<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductProperty extends Model
{
    use SoftDeletes;

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('value');
    }
}
