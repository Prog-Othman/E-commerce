<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $cart = Cart::withCount('items')
                    ->where('user_id', Auth::id())
                    ->first();
                
                $cartItemsCount = $cart ? $cart->items_count : 0;
                
                $view->with('cartItemsCount', $cartItemsCount);
            } else {
                $view->with('cartItemsCount', 0);
            }
        });
    }
}
