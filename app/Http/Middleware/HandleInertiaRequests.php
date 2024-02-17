<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'permissions' => Auth::user() ? $request->user()->getAllPermissions()->pluck('name') : null,
            ],
            'cart' => auth()->user()
                ? Cart::query()
                    ->where('user_id', auth()->user()->id)
                    ->select('id', 'product_id', 'quantity')
                    ->get()
                    ->toArray()
                : [],
            'favorites' => auth()->user()
                ? Favorite::query()
                    ->where('user_id', auth()->user()->id)
                    ->get()
                    ->toArray()
                : []
        ];
    }
}
