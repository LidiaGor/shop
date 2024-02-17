<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsGroups extends Model
{
    use SoftDeletes;

    public function parentGroup()
    {
        return $this->belongsTo(ProductsGroups::class, 'products_group_id')
            //исключение из связи самого себя если запрос из Групп товаров (products_groups)
            ->when($this->table === 'products_groups', function ($query) {
                $query->whereNot('id', $this->id);
            });
    }

    public function product_products_groups(){
        return $this->belongsToMany(Product::class);
    }
}
