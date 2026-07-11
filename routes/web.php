<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlidersController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ContactUsController;
use \App\Http\Controllers\FooterController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\ProfileController;
use \App\Http\Controllers\WishListController;
use \App\Http\Controllers\CartController;
use \App\Http\Controllers\CouponController;
use \App\Http\Controllers\PaymentController;


// app routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [AboutUsController::class, 'show'])->name('app.about-us');


// panel routes:
Route::middleware('auth')->get('/panel', function () {
    return view('panel.index');
})->name('panel.index');
// the slider:
Route::middleware('auth')->prefix('sliders')->group(function () {
    Route::get('/create', [SlidersController::class, 'create'])->name('slider.create');
    Route::post('/store', [SlidersController::class, 'store'])->name('slider.store');
    Route::get('/', [SlidersController::class, 'index'])->name('slider.index');
    Route::get('/{slider}/edit', [SlidersController::class, 'edit'])->name('slider.edit');
    Route::put('/{slider}', [SlidersController::class, 'update'])->name('slider.update');
    Route::delete('/{slider}', [SlidersController::class, 'destroy'])->name('slider.destroy');
});
// the feature
Route::middleware('auth')->prefix('feature')->group(function () {
    Route::get('/create', [FeatureController::class, 'create'])->name('feature.create');
    Route::post('/store', [FeatureController::class, 'store'])->name('feature.store');
    Route::get('/', [FeatureController::class, 'index'])->name('feature.index');
    Route::get('/{feature}/edit', [FeatureController::class, 'edit'])->name('feature.edit');
    Route::put('/{feature}', [FeatureController::class, 'update'])->name('feature.update');
    Route::delete('/{feature}', [FeatureController::class, 'destroy'])->name('feature.destroy');
});

// the aboutUs
Route::middleware('auth')->prefix('about')->group(function () {
    Route::get('/', [AboutUsController::class, 'index'])->name('about.index');
    Route::get('/{about}/edit', [AboutUsController::class, 'edit'])->name('about.edit');
    Route::put('/{about}', [AboutUsController::class, 'update'])->name('about.update');
});

// the ContactUs
Route::middleware('auth')->prefix('contact_us')->group(function () {
    Route::post('/store', [ContactUsController::class, 'store'])->name('contact.store');
    Route::get('/', [ContactUsController::class, 'index'])->name('contact.index');
    Route::get('/all', [ContactUsController::class, 'showall'])->name('contact.showall');
    Route::delete('/{contact_us}', [ContactUsController::class, 'destroy'])->name('contact.destroy');
    Route::get('/{contact_us}/show', [ContactUsController::class, 'show'])->name('contact.show');
//    Route::put('/{about}',[AboutUsController::class,'update'])->name('about.update');
});

// the footer
Route::middleware('auth')->prefix('footer')->group(function () {
    Route::get('/settings', [FooterController::class, 'index'])->name('footer.index');
    Route::get('/edit', [FooterController::class, 'edit'])->name('footer.edit');
    Route::put('/{footer}/update', [FooterController::class, 'update'])->name('footer.update');
});

// the categories
Route::middleware('auth')->prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/{category}/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/{category}/update', [CategoryController::class, 'update'])->name('category.update');
});

// the products
// panel
Route::middleware('auth')->prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/trash', [ProductController::class, 'trash'])->name('products.trash');
    Route::get('/{product_id}/recovery', [ProductController::class, 'recovery'])->name('products.recovery');
    Route::post('/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::put('/{product}/update', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::delete('/{product_id}/hard_delete', [ProductController::class, 'hard_delete'])->name('products.hard.delete');
});
// app
Route::prefix('products')->group(function () {
    Route::get('/single/{product:slug}', [ProductController::class, 'single'])->name('products.single');
});

// Restaurant Menu:
Route::get('/menu', [ProductController::class, 'menu'])->name('products.menu');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.loginform');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/check-otp', [AuthController::class, 'checkOtp'])->name('auth.checkotp');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('auth.resendOtp');
});

Route::get('/test', function () {
    return "hellow";
})->name('test')->middleware('auth');


// panel
Route::middleware('auth')->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/{user}', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/addresses', [ProfileController::class, 'addresses'])->name('profile.addresses');
    Route::get('/addresses/create', [ProfileController::class, 'addressCreate'])->name('addresses.create');
    Route::get('/{address}/edit', [ProfileController::class, 'addressEdit'])->name('addresses.edit');
    Route::put('/{address}/update', [ProfileController::class, 'addressUpdate'])->name('addresses.Update');
    Route::post('/addresses', [ProfileController::class, 'addressStore'])->name('addresses.store');
    Route::delete('/{address}', [ProfileController::class, 'addressesDestroy'])->name('addresses.destroy');

    Route::get('/wishlist', [ProfileController::class, 'showWishlist'])->name('wishlist.index');
    Route::get('/remove_from_wishlist', [WishListController::class, 'removeFromWishlist'])->name('removeFromWishlist');

    Route::get('/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/transactions', [ProfileController::class, 'transactions'])->name('profile.transactions');
});
Route::get('/add_to_wishlist', [WishListController::class, 'addToWishlist'])->name('addToWishlist');

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'cart'])->name('cart');
    Route::get('/add-to-cart', [CartController::class, 'increment'])->name('addToCart');
    Route::get('/remove-from-cart', [CartController::class, 'decrement'])->name('removeFromToCart');
    Route::get('/delete-cart', [CartController::class, 'deleteCart'])->name('deleteCart');
    Route::get('/merge', [CartController::class, 'mergecart'])->name('mergecart');
//    Route::get('/adjust', [CartController::class, 'AdjustmentCart'])->name('AdjustmentCart');
    Route::delete('{cart}/destroy', [CartController::class, 'destroy'])->name('destroyFromCart');
    Route::get('test', [CartController::class, 'test'])->name('test');
});


// the coupons
Route::middleware('auth')->prefix('coupon')->group(function () {
    Route::get('/', [CouponController::class, 'index'])->name('coupon.index');
    Route::get('/create', [CouponController::class, 'create'])->name('coupon.create');
    Route::post('/store', [CouponController::class, 'store'])->name('coupon.store');
    Route::delete('/{coupon}/destroy', [CouponController::class, 'destroy'])->name('coupon.destroy');
    Route::get('/{coupon}/edit', [CouponController::class, 'edit'])->name('coupon.edit');
    Route::get('/{coupon}/recovery', [CouponController::class, 'recovery'])->name('coupon.recovery');
    Route::get('/trash', [CouponController::class, 'trash'])->name('coupon.trash');
    Route::delete('/{coupon_id}/hard_delete', [CouponController::class, 'hard_delete'])->name('coupon.hard.delete');
    Route::put('/{coupon}/update', [CouponController::class, 'update'])->name('coupon.update');
    Route::get('/check', [CouponController::class, 'check'])->name('coupon.check');
    Route::get('/destroy-session', [CouponController::class, 'destroySession'])->name('coupon.destroy.session');
    Route::get('/user-destroy-session', [CouponController::class, 'userdestroySession'])->name('coupon.destroy.session.byuser');
});
Route::middleware('auth')->prefix('payment')->group(function () {
    Route::post('/send', [PaymentController::class, 'send'])->name('payment.send');
    Route::get('/verify', [PaymentController::class, 'callback'])->name('payment.callback');
});


