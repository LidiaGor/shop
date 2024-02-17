<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class PriceNormalizer
{
    public static function normalizeProductPrice(Model &$product)
    {
        self::normalizePrice($product);
    }

    private static function normalizePrice(Model &$product)
    {
        if (isset($product->lowerPrice[0]) && auth()->user()?->products_price_type_id) {
            $product->oldprice = $product->price;
            $product->price = $product->lowerPrice[0]?->value;
            unset($product->lowerPrice);
        }
    }

    public static function normalizeCollectionProductPrice(LengthAwarePaginator &$products)
    {
        foreach ($products as &$product) {
            self::normalizePrice($product);
        }
    }
}
