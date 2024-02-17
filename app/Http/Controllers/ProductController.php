<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Banner;
use App\Models\Product;
use App\Services\PriceNormalizer;
use App\Services\Prices;
use App\Services\Services;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show(string $product_slug)
    {
        //TODO всё же вернуть логику отдельных цен по группам юзера
        //when user->can('price_1') fn => $query->where('price_group', user->getPriceGroup)

        $user = auth()->user();

        $product = Product::query()
//            ->with('properties')
            ->with('products_groups:id,name,slug')
            ->when($user?->products_price_type_id, function ($query) use ($user) {
                $query->with([
                    'lowerPrice' => fn($query) => $query->where(
                        'products_price_type_id',
                        $user->products_price_type_id
                    )
                ]);
            })
            ->where('slug', $product_slug)
            ->firstOrFail();

        PriceNormalizer::normalizeProductPrice($product);

//        dd($product);

        return Inertia::render(
            'Products/ProductShow',
            compact('product')
        );
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $user = auth()->user();

        $products = (new Product())
            ->where('active', 1)
            ->with('products_groups')
//            ->whereNotNull('price')
            ->when($search, function ($query, $query_data) {
                $query
                    ->where('name', 'like', '%' . $query_data . '%')
                    ->orWhere('description', 'like', '%' . $query_data . '%');
            })
            ->when($user?->products_price_type_id, function ($query) use ($user) {
                $query->with([
                    'lowerPrice' => fn($query) => $query->where(
                        'products_price_type_id',
                        $user->products_price_type_id
                    )
                ]);
            })
            ->orderBy('sort')
            ->orderBy('name')
            ->get();

        if ($products) {
            foreach ($products as $product) {
                PriceNormalizer::normalizeProductPrice($product);
            }

//            $products = $products->whereNotNull('oldprice');
        }

        return Inertia::render(
            'Search/SearchShow',
            compact('products')
        );
    }
}
