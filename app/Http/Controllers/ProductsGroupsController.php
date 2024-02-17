<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductsGroupsRequest;
use App\Http\Requests\UpdateProductsGroupsRequest;
use App\Models\Product;
use App\Models\ProductsGroups;
use App\Services\PriceNormalizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use PhpParser\Builder;

class ProductsGroupsController extends Controller
{
    /**
     * get product groups for header menu
     * @return \Illuminate\Http\JsonResponse
     */
    public function headerMenuGroups()
    {
        return response()->json(
            ProductsGroups::query()
                ->where('active', 1)
                ->whereHas('product_products_groups')
                ->get()
        );
    }

    public function show(Request $request, string $group_slug)
    {
        $user = auth()->user();

        $type = (int)$request->get('type') ?? 0;

        $products = (new Product())
            ->where('active', 1)
            ->with('products_groups')
//            ->whereNotNull('price')
            ->whereHas('products_groups', function ($query) use ($group_slug) {
                $query->where('slug', $group_slug);
            })
            ->when($type === 1, function ($query) {
                $query
                    ->orderBy('created_at');
            })
            ->when($type === 2, function ($query) {
                $query
                    ->orderBy('price');
            })
            ->when($type === 3, function ($query) {
                $query
                    ->orderByDesc('price');
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

        if ($type === 4) {
            foreach ($products as $product) {
                PriceNormalizer::normalizeProductPrice($product);
            }

            $products = $products->whereNotNull('oldprice');
        }

        $groups = ProductsGroups::query()
            ->where('active', 1)
            ->with('product_products_groups')
            ->whereHas('product_products_groups')
            ->select('id','name','slug')
            ->get();

        $this_group = $groups->where('slug', $group_slug)->first();

        if (!$this_group) {
            abort(404);
        }

        return Inertia::render(
            'Catalog/GroupShow',
            compact('products', 'groups', 'this_group', 'type')
        );
    }
}
