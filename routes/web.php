<?php

use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Category;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartDetailController;
use App\Http\Controllers\UserManagementController;

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

Route::get('/admin', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('admin')->name('admin.')->group(function(){
    Route::middleware(['guest:admin','PreventBackHistory'])->group(function(){
        Route::view('/login','dashboard.login')->name('login'); 
        Route::view('/register', 'dashboard.register')->name('register');
        Route::post('/create', [AdminController::class,'create'])->name('create');
        Route::post('/check',[AdminController::class,'check'])->name('check');
        Route::get('/forgot',[AdminController::class,'forgotPassword'])->name('forgot_password');
        Route::post('/reset-link',[AdminController::class,'resetLink'])->name('reset_link');
        Route::get('/reset/{token}',[AdminController::class,'showReset'])->name('show_reset');
        Route::post('/reset-password',[AdminController::class,'resetPassword'])->name('reset_password');
        
    });
    Route::middleware(['auth:admin','PreventBackHistory'])->group(function(){
        Route::get('/home', [AdminController::class, 'index'])->name('home');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::post('/mark-as-read', [AdminController::class,'markNotification'])->name('markNotification');
        
        //Profile
        Route::get('/profile',[AdminController::class, 'show'])->name('profile');
        Route::patch('/save-profile/{id}',[AdminController::class, 'changeProfile'])->name('changeProfile');
        Route::patch('/change-password/{id}',[AdminController::class, 'changePassword'])->name('changePassword');

        //User Management
        Route::get('/user-management',[UserManagementController::class, 'index'])->name('userManagement');
        Route::get('/add-user', [UserManagementController::class,'create'])->name('add_user');
        Route::post('/store-user', [UserManagementController::class, 'store'])->name('store_user');
        Route::get('/edit-user/{id}', [UserManagementController::class, 'edit'])->name('edit_user');
        Route::patch('/update-user/{id}', [UserManagementController::class, 'update'])->name('update_user');
        Route::get('/delete-user/{id}', [UserManagementController::class, 'destroy'])->name('delete_user');
        Route::get('/reset-user/{id}', [UserManagementController::class, 'reset'])->name('reset_user');
        Route::get('/data-user', function() {
            return DataTables::of(User::query())
            ->addColumn('action', 'usermanagement.action')
            ->make(true);
        })->name('data_user');

        //Category
        Route::get('/category',[CategoryController::class, 'index'])->name('category');
        Route::get('/add-category', [CategoryController::class,'create'])->name('add_category');
        Route::post('/store-category', [CategoryController::class, 'store'])->name('store_category');
        Route::get('/edit-category/{category:id}', [CategoryController::class, 'edit'])->name('edit_category');
        Route::post('/update-category/{category:id}', [CategoryController::class, 'update'])->name('update_category');
        Route::get('/delete-category/{id}/{pic}', [CategoryController::class, 'destroy'])->name('delete_category');
        Route::get('/data-category', function() {
            return DataTables::of(Category::query())
            ->addColumn('action', 'category.action')
            ->make(true);
        })->name('data_category');
        Route::get('/show-by-category/{category:id}',[CategoryController::class, 'showbycategory'])->name('show_by_category');
        
        //Brand
        Route::get('/brand',[BrandController::class, 'index'])->name('brand');
        Route::get('/add-brand', [BrandController::class,'create'])->name('add_brand');
        Route::post('/store-brand', [BrandController::class, 'store'])->name('store_brand');
        Route::get('/edit-brand/{brand:id}', [BrandController::class, 'edit'])->name('edit_brand');
        Route::post('/update-brand/{brand:id}', [BrandController::class, 'update'])->name('update_brand');
        Route::get('/delete-brand/{id}/{pic}', [BrandController::class, 'destroy'])->name('delete_brand');
        Route::get('/data-brand', function() {
            return DataTables::of(Brand::query())
            ->addColumn('action', 'brand.action')
            ->make(true);
        })->name('data_brand');
        Route::get('/show-by-brand/{brand:id}',[BrandController::class, 'showbybrand'])->name('show_by_brand');
        
        //Product
        Route::get('/product',[ProductController::class, 'indexAdmin'])->name('product');
        Route::get('/add-product', [ProductController::class,'create'])->name('add_product');
        Route::post('/store-product', [ProductController::class, 'store'])->name('store_product');
        Route::get('/edit-product/{product:id}', [ProductController::class, 'edit'])->name('edit_product');
        Route::post('/update-product/{product:id}', [ProductController::class, 'update'])->name('update_product');
        Route::get('/delete-product/{id}/{pic}', [ProductController::class, 'destroy'])->name('delete_product');
        Route::get('/data-product', function() {
            return DataTables::of(Product::with('category', 'brand')->get())
            ->addColumn('action', 'product.action')
            ->make(true);
        })->name('data_product');
        Route::get('/add-stock/{product:id}', [ProductController::class,'addStock'])->name('add_stock');
        Route::post('/update-stock/{product:id}', [ProductController::class, 'updateStock'])->name('update_stock');
        
        //Income
        Route::get('/income',[IncomeController::class, 'index'])->name('income');
        Route::get('/add-income', [IncomeController::class,'create'])->name('add_income');
        Route::post('/store-income', [IncomeController::class, 'store'])->name('store_income');
        Route::get('/edit-income/{income:id}', [IncomeController::class, 'edit'])->name('edit_income');
        Route::post('/update-income/{id}', [IncomeController::class, 'update'])->name('update_income');
        Route::get('/delete-income/{id}', [IncomeController::class, 'destroy'])->name('delete_income');
        Route::get('/data-income', function() {
            return DataTables::of(Income::query())
            ->addColumn('action', 'income.action')
            ->make(true);
        })->name('data_income');
        Route::post('/export', [IncomeController::class, 'fileExport'])->name('export');

        //Expense
        Route::get('/expense',[ExpenseController::class, 'index'])->name('expense');
        Route::get('/add-expense', [ExpenseController::class,'create'])->name('add_expense');
        Route::post('/store-expense', [ExpenseController::class, 'store'])->name('store_expense');
        Route::get('/edit-expense/{id}', [ExpenseController::class, 'edit'])->name('edit_expense');
        Route::post('/update-expense/{id}', [ExpenseController::class, 'update'])->name('update_expense');
        Route::get('/delete-expense/{id}', [ExpenseController::class, 'destroy'])->name('delete_expense');
        Route::get('/data-expense', function() {
            return DataTables::of(Expense::query())
            ->addColumn('action', 'expense.action')
            ->make(true);
        })->name('data_expense');
        
        //Order
        Route::get('/order',[OrderController::class, 'indexAdmin'])->name('order');
        Route::get('/add-order', [OrderController::class,'create'])->name('add_order');
        Route::post('/store-order', [OrderController::class, 'store'])->name('store_order');
        Route::post('/confirm-payment/{order:id}', [OrderController::class, 'confirmPayment'])->name('confirm_payment');
        Route::post('/not-confirm/{order:id}', [OrderController::class, 'notConfirm'])->name('not_confirm');
        Route::get('/add-resi/{order:id}', [OrderController::class,'addResi'])->name('add_resi');
        Route::post('/update-resi/{id}', [OrderController::class, 'updateResi'])->name('update_resi');
        Route::get('/order-details/{order:id}', [OrderController::class,'show'])->name('order_details');
        Route::get('/data-order', function() {
            return DataTables::of(Order::query())
            // ->addColumn('action', 'order.action')
            ->addColumn('details', function ($item) {
                return '<a 
                class="button detail text-primary" 
                style="cursor:pointer"
                onclick="event.preventDefault();detail('.$item->id.')" 
                data-bs-toggle="tooltip" 
                title="detail order">Order Details</a>';
            })
            ->rawColumns(['details'])
            ->make(true);
        })->name('data_order');
        Route::get('/complete-order/{order:id}', [OrderController::class, 'complete'])->name('complete_order');
    });
});

// Route::prefix('user')->name('user.')->group(function(){
    // // Product
    // Route::get('/', [ProductController::class, 'index'])->name('shop');
    // Route::get('/shop', [ProductController::class, 'shop'])->name('shop_detail');
    // Route::get('/shop/products/{product:id}', [ProductController::class, 'show'])->name('product_detail');
    
    // // Brand
    // Route::get('/shop/brands/{brand:id}', [BrandController::class, 'show'])->name('brand_detail');
    
    // // Category
    // Route::get('/shop/categories/{category:id}', [CategoryController::class, 'show'])->name('category_detail');
    
// });

// Product
Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
Route::get('/shop/products/{product:id}', [ProductController::class, 'show'])->name('product_detail');

Route::middleware(['guest:web','PreventBackHistory'])->group(function(){
    // // Autentikasi
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/register', [ProfileController::class, 'create'])->name('register');
    Route::post('/register', [ProfileController::class, 'store']);

    // Forgot Password    
    Route::get('/password/forgot', [ProfileController::class, 'forgot_password'])->name('forgot_password');
    Route::post('/password/forgot', [ProfileController::class, 'resetLink'])->name('reset_link');
    Route::get('/password/reset/{token}', [ProfileController::class, 'showReset'])->name('show_reset');
    Route::post('/password/reset', [ProfileController::class, 'resetPassword'])->name('reset_password');
});

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::middleware(['auth:web','PreventBackHistory'])->group(function(){
    // //Autentikasi
    Route::get('/logout', [LoginController::class, 'logout'])->name('user_logout');
    
    // Profil User
    Route::get('/profile/edit/{user:id}', [ProfileController::class, 'edit'])->name('edit_profile');
    Route::post('/profile/edit/{user:id}', [ProfileController::class, 'update']);
    Route::get('/profile/delete/{user:id}', [ProfileController::class, 'destroy'])->name('delete_user');
    Route::get('/profile/password/{user:id}', [ProfileController::class, 'edit_password'])->name('edit_password');
    Route::post('/profile/password/{user:id}', [ProfileController::class, 'update_password'])->name('update_password');

    // Cart
    Route::get('/carts/add_one/{product:id}', [ProductController::class, 'add_one_to_cart'])->name('add_one_to_cart');
    Route::post('/shop/products/{product:id}', [ProductController::class, 'add_to_cart'])->name('add_to_cart');
    Route::get('/carts/edit/{user:id}', [CartDetailController::class, 'edit'])->name('cart');
    Route::post('/carts/update/{cart_detail:id}', [CartDetailController::class, 'update'])->name('update_cart');
    Route::get('/carts/subtotal', [CartDetailController::class, 'getSubtotal'])->name('subtotal');
    Route::get('/carts/delete/{cart_detail:id}', [CartDetailController::class, 'destroy'])->name('delete_cart');
    Route::get('/checkout/{user:id}', [CartDetailController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/{user:id}', [CartDetailController::class, 'order'])->name('order');
    
    // Order
    Route::get('/orders/{user:id}', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/delete/{order:id}', [OrderController::class, 'destroy'])->name('delete_order');
    Route::get('/orders/complete/{order:id}', [OrderController::class, 'complete'])->name('complete_order');
    Route::get('/orders/pay/{order:id}', [OrderController::class, 'edit'])->name('pay_order');
    Route::post('/orders/pay/{order:id}', [OrderController::class, 'update'])->name('confirm_pay');
    Route::get('/orders/repay/{order:id}', [OrderController::class, 'repay'])->name('repay_order');
    Route::post('/orders/repay/{order:id}', [OrderController::class, 'reupload'])->name('confirm_repay');
    Route::get('/history/{user:id}', [OrderController::class, 'history'])->name('history');
    Route::get('/reorder/{order:id}', [OrderController::class, 'reorder'])->name('reorder');
});
