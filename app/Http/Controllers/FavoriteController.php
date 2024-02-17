<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use App\Services\PriceNormalizer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = auth()?->user();

        $favorites = Favorite::query()
            ->where('user_id', $user->id)
            ->get()
            ->pluck('product_id');

        $products = (new Product())
            ->where('active', 1)
            ->with('products_groups')
            ->whereIn('id', $favorites)
//            ->whereNotNull('price')
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
            foreach ($products as &$product) {
                PriceNormalizer::normalizeProductPrice($product);
            }
        }


        if (!$products || !count($products)) {
            return to_route('home');

        } else {
            return Inertia::render(
                'Favorites/FavoritesIndex',
                compact('products')
            );
        }
    }

    public function update(Request $request)
    {
        $user = auth()?->user();
        $product_id = $request->get('product');

        if ($user && $product_id) {
            $not_new = Favorite::query()
                ->where('user_id', $user->id)
                ->where('product_id', $product_id)
                ->first();

            if (!$not_new) {
                $favorite = (new Favorite());
                $favorite->user_id = $user->id;
                $favorite->product_id = $product_id;
                $favorite->save();

            } else {
                $this->destroy($product_id);
            }
        }

        return response()->json(
            Favorite::query()
                ->where('user_id', $user->id)
                ->get()
        );
    }

    public function destroy($product_id)
    {
        $user = auth()?->user();

        if ($user && $product_id) {
            Favorite::query()
                ->where('user_id', $user->id)
                ->where('product_id', $product_id)
                ->delete();
        }
    }

}
