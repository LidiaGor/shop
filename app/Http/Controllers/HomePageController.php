<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Cart;
use App\Models\Company;
use App\Models\Product;
use App\Models\ProductOld;
use App\Models\ProductsGroups;
use App\Models\Warehouse;
use App\Services\PriceNormalizer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class HomePageController extends Controller
{
    public function index()
    {
        $banners_horizontal = Banner::query()
            ->where('type', 1)
            ->first();

        $banners_double = Banner::query()
            ->where('type', 2)
            ->limit(2)
            ->get();

        return Inertia::render(
            'Home',
            compact('banners_horizontal', 'banners_double')
        );
    }

    public function getSpecialOffers()
    {
        $user = auth()->user();

        $products = Product::query()
            ->with('products_groups:id,name,slug')
//            ->whereNotNull('price')
            ->when($user?->products_price_type_id, function ($query) use ($user) {
                $query->with([
                    'lowerPrice' => fn($query) => $query->where(
                        'products_price_type_id',
                        $user->products_price_type_id
                    )
                ]);
            })
            ->paginate(10);

        PriceNormalizer::normalizeCollectionProductPrice($products);

        return response()->json(
            $products
        );
    }
}
