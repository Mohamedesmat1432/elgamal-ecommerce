<?php

use App\Livewire\Auth\ForgetPasswordPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\CancelPage;
use App\Livewire\CartPage;
use App\Livewire\CategoriesPage;
use App\Livewire\CheckoutPage;
use App\Livewire\HomePage;
use App\Livewire\MyOrdersPage;
use App\Livewire\OrderDetailsPage;
use App\Livewire\ItemDetailsPage;
use App\Livewire\ItemsPage;
use App\Livewire\SuccessPage;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function(){
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/livewire/update', $handle);
        });

        Route::get('/', HomePage::class)->name('home');
        Route::get('/categories', CategoriesPage::class)->name('categories');
        Route::get('/items', ItemsPage::class)->name('items');
        Route::get('/items/{slug}', ItemDetailsPage::class)->name('item.details');
        Route::get('/cart', CartPage::class)->name('cart');
        
        Route::middleware('guest')->group(function () {
            Route::get('/login', LoginPage::class)->name('login');
            Route::get('/register', RegisterPage::class)->name('register');
            Route::get('/forget', ForgetPasswordPage::class)->name('password.forget');
            Route::get('/reset/{token}', ResetPasswordPage::class)->name('password.reset');
        });
        
        Route::middleware('auth')->group(function () {
            Route::get('/my-orders', MyOrdersPage::class)->name('my.orders');
            Route::get('/my-order-details/{order}', OrderDetailsPage::class)->name('order.details');
            Route::get('/checkout', CheckoutPage::class)->name('checkout');
            Route::get('/success', SuccessPage::class)->name('success');
            Route::get('/cancel', CancelPage::class)->name('cancel');
        });

    });

