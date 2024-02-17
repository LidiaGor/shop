<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteCartRequest;
use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Product;
use App\Services\PriceNormalizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //TODO тут из-за мидлварки авторизации проверка избыточна, ларка сама запросит залогиниться
        $user = auth()->user();
        $carts = Cart::query()
            ->where('user_id', Auth::user()->id)
            ->with('product')
            ->get();

        foreach ($carts as &$cart) {
            PriceNormalizer::normalizeProductPrice($cart->product);
        }

        return Inertia::render(
            'Carts/Cart',
            compact(
                'carts'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request)
    {
        //TODO если количество меньше или равно нулю, то удалять из корзины

        $cartRaw = $request->validated();

        $cart = Cart::query()
            ->where('user_id', auth()->user()->id)
            ->where('product_id', $cartRaw['product'])
            ->firstOrNew();

        /* if ($cartRaw['is_cart']) {
             $cart->forceFill([
                 'user_id' => auth()->user()->id,
                 'product_id' => $cartRaw['product'],
                 'quantity' => $cartRaw['quantity'],
             ]);

             $cart->save();

             unset($cartRaw['is_cart']);

             return true;
         }*/

        $cart->forceFill([
            'user_id' => auth()->user()->id,
            'product_id' => $cartRaw['product'],
            'quantity' => $cartRaw['quantity'],
        ]);

        $cart->save();

        return response()->json(
            Cart::where('user_id', auth()->user()->id)
                ->select('id', 'product_id', 'quantity')
                ->get()
        );
    }

    /**
     * Очистка корзины
     */
    public function destroy(Request $request, $id = 0)
    {
        $cart = Cart::where('user_id', auth()->user()->id)
            ->where('id', $id)
            ->first();

        $cart?->delete();

        return response()->json(
            Cart::where('user_id', auth()->user()->id)
                ->select('id', 'product_id', 'quantity')
                ->get()
        );
    }
}
