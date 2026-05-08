<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ContactFormController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Storefront pages
Route::view('/shop', 'storefront.shop')->name('shop');
Route::view('/cart', 'storefront.cart')->name('cart');
Route::view('/checkout', 'storefront.checkout')->name('checkout');
Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchase.store');
Route::post('/contact-message', [ContactFormController::class, 'store'])->name('contact.message');
Route::view('/about', 'storefront.about')->name('about');
Route::view('/faq', 'storefront.faq')->name('faq');
Route::view('/contact', 'storefront.contact')->name('contact');
Route::view('/thank-you', 'storefront.thank-you')->name('thank-you');
Route::get('/product/{slug?}', function ($slug = null) {
    $allProducts = config('products');
    $product = collect($allProducts)->firstWhere('slug', $slug);

    if (!$product) {
        $product = [
            'slug'        => $slug,
            'name'        => ucwords(str_replace('-', ' ', $slug ?? 'Product')),
            'price'       => 19.99,
            'price_mxn'   => 339.99,
            'description' => null,
            'image'       => null,
            'icon'        => '📦',
            'category'    => 'accessories',
            'models'      => ['Standard'],
            'eta'         => 'Arriving in 2-4 weeks',
        ];
    }

    $suggested = collect($allProducts)
        ->where('slug', '!=', $slug)
        ->shuffle()
        ->take(4)
        ->values()
        ->all();

    return view('storefront.product', compact('product', 'suggested'));
})->name('product.show');

Route::get('/dashboard', [DashboardController::class, 'management'])
    ->middleware(['auth', 'admin'])
    ->name('management.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Panel de administracion
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class)->except(['create', 'store']);

    // CRM
    Route::resource('contacts', ContactController::class);
    Route::resource('sales', SaleController::class)->except(['show']);
    Route::post('activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::delete('activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');
});

require __DIR__.'/auth.php';
