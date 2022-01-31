<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\VendorAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BusinessCategoryController;
use App\Http\Controllers\SubscriptionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//**********ADMIN**********
Route::domain('admin.' . config('app.url'))->group(function () {
  // Auth
  Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
  Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.auth');
  Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
 //Auth Guarded
  Route::middleware(['authadmin'])->group(function() {
    
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/table', function() {
      $page_title = 'Admins';
      $crumbs = ['Admins' ];
      return view('app-pages.admin.table', compact('page_title', 'crumbs'));
    });

    // Admin
    Route::get('admins/new-admin', [AdminController::class, 'create'])->name('admins.create');
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
    Route::get('/admins/admins', [AdminController::class, 'refreshAdmin'])->name('admins.refresh');
    Route::post('/admins', [AdminController::class, 'store'])->name('admins.register');
    Route::get('/admins/{id}', [AdminController::class, 'show'])->name('admins.show');
    Route::get('/admins/{id}/edit', [AdminController::class, 'edit'])->name('admins.edit');
    Route::post('/admins/{id}/edit', [AdminController::class, 'update'])->name('admins.update');
    Route::post('/admins/mass-update', [AdminController::class, 'massUpdate'])->name('admins.mass.update');

    // Vendor
    Route::get('vendors/new-vendor', [VendorController::class, 'create'])->name('vendors.create');
    Route::get('/vendors', [VendorController::class, 'index'])->name('vendors.index');
    Route::get('/vendors/vendors', [VendorController::class, 'refreshVendor'])->name('vendors.refresh');
    Route::post('/vendors', [VendorController::class, 'store'])->name('vendors.register');
    Route::get('/vendors/{id}', [VendorController::class, 'show'])->name('vendors.show');
    Route::get('/vendors/{id}/edit', [VendorController::class, 'edit'])->name('vendors.edit');
    Route::post('/vendors/{id}/edit', [VendorController::class, 'update'])->name('vendors.update');
    Route::post('/vendors/mass-update', [VendorController::class, 'massUpdate'])->name('vendors.mass.update');

    // Buyer
    Route::get('buyers/new-buyer', [BuyerController::class, 'create'])->name('buyers.create');
    Route::get('/buyers', [BuyerController::class, 'index'])->name('buyers.index');
    Route::get('/buyers/buyers', [BuyerController::class, 'refreshBuyer'])->name('buyers.refresh');
    Route::post('/buyers', [BuyerController::class, 'store'])->name('buyers.register');
    Route::get('/buyers/{id}', [BuyerController::class, 'show'])->name('buyers.show');
    Route::get('/buyers/{id}/edit', [BuyerController::class, 'edit'])->name('buyers.edit');
    Route::post('/buyers/{id}/edit', [BuyerController::class, 'update'])->name('buyers.update');
    Route::post('/buyers/mass-update', [BuyerController::class, 'massUpdate'])->name('buyers.mass.update');

    // Business  
    Route::get('/businesses', [BusinessController::class, 'index']);
    Route::get('/businesses/businesses', [BusinessController::class, 'refreshBusiness']);
    Route::get('businesses/new-business', [BusinessController::class, 'create'])->name('business.create');
    Route::post('/businesses', [BusinessController::class, 'store'])->name('business.register');
    Route::get('/businesses/{id}', [BusinessController::class, 'show'])->name('business.show');
    Route::get('/businesses/{id}/edit', [BusinessController::class, 'edit'])->name('business.edit');
    Route::post('/businesses/{id}/edit', [BusinessController::class, 'update'])->name('business.update');
    Route::post('/businesses/mass-update', [BusinessController::class, 'massUpdate'])->name('business.mass.update');

    
    // Business Category
    Route::get('/business-categories', [BusinessCategoryController::class, 'index']);
    Route::get('/business/categories', [BusinessCategoryController::class, 'refreshBC']);
    Route::get('business-categories/new-category', [BusinessCategoryController::class, 'create'])->name('BC.create');
    Route::post('/business-categories', [BusinessCategoryController::class, 'store'])->name('BC.register');
    Route::get('/business-categories/{id}', [BusinessCategoryController::class, 'show'])->name('buyers.show');
    Route::get('/business-categories/{id}/edit', [BusinessCategoryController::class, 'edit'])->name('buyers.edit');
    Route::post('/business-categories/{id}/edit', [BusinessCategoryController::class, 'update'])->name('bc.update');
    Route::post('/business-categories/mass-update', [BusinessCategoryController::class, 'massUpdate'])->name('buyers.mass.update');

    
    // Subscription
    Route::get('/subscriptions', [SubscriptionController::class, 'index']);
    Route::get('/subscriptions/subscriptions', [SubscriptionController::class, 'refreshSub']);
    Route::get('subscriptions/new-subscription', [SubscriptionController::class, 'create'])->name('sub.create');
    Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('sub.register');
    Route::get('/subscriptions/{id}', [SubscriptionController::class, 'show'])->name('subscription.show');
    Route::get('/subscriptions/{id}/edit', [SubscriptionController::class, 'edit'])->name('sub.edit');
    Route::post('/subscriptions/{id}/edit', [SubscriptionController::class, 'update'])->name('sub.update');
    Route::post('/subscriptions/mass-update', [SubscriptionController::class, 'massUpdate'])->name('sub.mass.update');

    // Product  
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/products', [ProductController::class, 'refreshProduct']);
    Route::post('/products/mass-update', [ProductController::class, 'massUpdate'])->name('product.mass.update');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/products/{id}/edit', [ProductController::class, 'update'])->name('product.update');
    Route::get('products/{business}/new-product', [ProductController::class, 'create'])->name('product.create');
    Route::post('/products/{business}', [ProductController::class, 'store'])->name('product.register');

    // Route::resource('photos', PhotoController::class)->only([
    //   'index', 'show'
    // ]);

    // Route::resource('photos', PhotoController::class)->except([
    //   'create', 'store', 'update', 'destroy'
    // ]);

  });
});



// **********VENDOR**********
Route::domain('vendor.' . config('app.url'))->group(function () {
  // Auth
  Route::get('/login', [VendorAuthController::class, 'showLogin'])->name('vendor.login');
  Route::post('/login', [VendorAuthController::class, 'login'])->name('vendor.auth');
  Route::post('/logout', [VendorAuthController::class, 'logout'])->name('vendor.logout');

  //Auth Guarded
  Route::middleware(['authvendor'])->group(function() {
    Route::get('/', [VendorController::class, 'dashboard'])->name('vendor.dashboard');
    
  });
});



//**********USERS**********
//Auth
Auth::routes();
Route::middleware(['auth'])->group(function() {
  Route::get('/dashboard', [BuyerController::class, 'dashboard'])->name('dashboard');
});



//***********PAGES***********
Route::get('/',  [PagesController::class, 'index'])->name('home');
Route::get('category/{category}',  [CategoryController::class, 'categoryProducts'])->name('category.products');
Route::get('/product/{product}/{slug}',  [ProductController::class, 'product'])->name('product.product');
Route::get('/cart',  [CartController::class, 'index'])->name('cart.index');
// Route::get('/dashboard', [PagesController::class, 'dash'])->name('dash');
// Route::middleware(['auth', 'verified'])->get('/dashboard', [PagesController::class, 'dash'])->name('dash');






// /env('APP_URL')










//ADMIN
