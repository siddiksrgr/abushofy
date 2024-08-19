<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ConfirmController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\AcceptProductController;
use App\Http\Controllers\PreOrderCartController;
use App\Http\Controllers\CheckoutPreOrderController;
use App\Http\Controllers\ComplainController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\ClothingSizeController;
use App\Http\Controllers\Admin\AccessoriesSizeController;
use App\Http\Controllers\Admin\ClothingStockController;
use App\Http\Controllers\Admin\AccessoriesStockController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\ConfirmationController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\ConfirmationPreOrderController;
use App\Http\Controllers\Admin\AdminComplainController;
use App\Http\Controllers\Admin\ExportPDFController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminAccountController;


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

Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home'); 
Route::get('/category/{id}', [CategoriesController::class, 'detail']);
Route::get('/detail/{id}', [DetailController::class, 'index']);

Route::middleware(['auth', 'checkRole:pembeli'])->group(function () { 
    Route::resource('cart', CartController::class);
    Route::resource('confirm', ConfirmController::class);
    Route::resource('transaction', TransactionController::class); 
    Route::get('/transaction-expired/{id}', [TransactionController::class, 'expired']);
    Route::resource('review', ReviewController::class);
    Route::resource('/account', AccountController::class);
    Route::post('/account/photo/{id}', [AccountController::class, 'updatePhoto']);
    Route::post('/accept/store', [AcceptProductController::class, 'store']);
    Route::resource('pre-order-cart', PreOrderCartController::class);
    Route::post('/pre-order-checkout', [CheckoutPreOrderController::class, 'checkout']);
    Route::get('/pre-orders', [TransactionController::class, 'pre_orders']);
    Route::get('/complains', [ComplainController::class, 'index']);
    Route::post('/complain/create/{id}', [ComplainController::class, 'create']);
    Route::post('/complain/{id}', [ComplainController::class, 'store']);
    Route::get('/complain/details/{id}', [ComplainController::class, 'show']);
    Route::get('/complain/shipping/{id}', [ComplainController::class, 'shipping_create']);
    Route::post('/complain/shipping/{id}', [ComplainController::class, 'shipping_store']);
    Route::get('/complain/shipping/accept/{id}', [ComplainController::class, 'accept']);
});

Route::prefix('admin')->middleware(['auth', 'checkRole:admin,pemilik,pegawai'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('gallery', ProductGalleryController::class);
    Route::resource('clothing-size', ClothingSizeController::class);
    Route::resource('accessories-size', AccessoriesSizeController::class);
    Route::resource('clothing-stock', ClothingStockController::class);
    Route::resource('accessories-stock', AccessoriesStockController::class);
    Route::resource('transactions', AdminTransactionController::class);
    Route::resource('confirmations', ConfirmationController::class);
    Route::resource('shippings', ShippingController::class);
    Route::get('/shippings/create/{id}', [ShippingController::class, 'create']);
    Route::resource('complains', AdminComplainController::class);
    Route::post('/complain/shipping/create/{id}', [AdminComplainController::class, 'shipping_create']);
    Route::post('/complain/shipping/{id}', [AdminComplainController::class, 'shipping_store']); 
 
    Route::get('/stock-accessories/exportPDF', [ExportPDFController::class, 'stock_accessories']);
    Route::get('/stock-clothing/exportPDF', [ExportPDFController::class, 'stock_clothing']);
    Route::get('/complain/exportPDF', [ExportPDFController::class, 'complain']);
    Route::get('/payment/exportPDF', [ExportPDFController::class, 'payment']);
    Route::get('/shipping/exportPDF', [ExportPDFController::class, 'shipping']);
    Route::get('/transaction/exportPDF', [ExportPDFController::class, 'transaction']);
    Route::resource('users', UserController::class);
    Route::resource('account', AdminAccountController::class);
});