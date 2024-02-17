<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model
{
    use SoftDeletes;

    protected $casts = [
      'gallery' => 'array'
    ];

    public function products_groups(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ProductsGroups::class);
    }

    public function properties(){
        return $this->belongsToMany(ProductProperty::class)->withPivot('value');
    }

    public function lowerPrice()
    {
        return $this->hasMany(ProductsPrice::class);
    }
}
