<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $cartItems = Cart::with(['book.category'])
                    ->where('user_id', Auth::id())
                    ->get();
            } else {
                $cartItems = collect();
            }

            $view->with('cartItems', $cartItems);
        });
    }
}
