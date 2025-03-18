<?php

use App\Http\Controllers\Admin\AdminMainController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\Customer\CustomerMainController;
use App\Http\Controllers\MasterCategoryController;
use App\Http\Controllers\MasterSubCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\SellerMainController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerStoreController;
use Illuminate\Support\Facades\Route;
use App\Livewire\ProductCatalog;

// Rota pública para agendamentos JSON (acessível por todos)
Route::get('/agendamentos/json', [AgendamentoController::class, 'getAgendamentos'])->name('agendamentos.json');

// Rota pública para a página inicial
Route::get('/', function () {
    return view('welcome');
});

// Rotas públicas para procurar produtos (acessíveis sem login)
Route::get('/product/procurar', [ProductController::class, 'procurar'])->name('product.procurar');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::get('/catalogo', ProductCatalog::class)->name('catalogo');

// Rotas de agendamento (acessíveis por todos os usuários, sem login)
Route::prefix('agendamento')->group(function () {
    Route::controller(AgendamentoController::class)->group(function () {
        Route::get('/', 'create')->name('agendamento.create');
        Route::post('/', 'store')->name('agendamento.store');
        Route::get('/lista', 'index')->name('agendamento.index');
    });
});

// Admin routes (mantêm restrição de autenticação e role)
Route::middleware(['auth', 'verified', 'rolemanager:admin'])->prefix('admin')->group(function () {
    Route::controller(AdminMainController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('admin');
        Route::get('/settings', 'setting')->name('admin.settings');
        Route::get('/manage/users', 'manage_user')->name('admin.manage.user');
        Route::get('/manage/stores', 'manage_stores')->name('admin.manage.store');
        Route::get('/cart/history', 'cart_history')->name('admin.cart.history');
        Route::get('/order/history', 'order_history')->name('admin.order.history');
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category/create', 'index')->name('category.create');
        Route::get('/category/manage', 'manage')->name('category.manage');
    });

    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('/subcategory/create', 'index')->name('subcategory.create');
        Route::get('/subcategory/manage', 'manage')->name('subcategory.manage');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('/product/manage', 'index')->name('product.manage');
        Route::get('/product/review/manage', 'review_manage')->name('product.review.manage');
    });

    Route::controller(ProductAttributeController::class)->group(function () {
        Route::get('/product_attribute/create', 'index')->name('product_attribute.create');
        Route::get('/product_attribute/manage', 'manage')->name('product_attribute.manage');
        Route::post('/product_attribute/create', 'createattribute')->name('attribute.create');
        Route::get('/product_attribute/edit/{id}', 'showattribute')->name('product_attribute.edit');
        Route::post('/product_attribute/update/{id}', 'updateattribute')->name('product_attribute.update');
        Route::delete('/product_attribute/delete/{id}', 'deleteattribute')->name('product_attribute.delete');
    });
});

// Vendor routes (mantêm restrição de autenticação e role)
Route::middleware(['auth', 'verified', 'rolemanager:vendor'])->prefix('vendor')->group(function () {
    Route::controller(SellerMainController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('vendor');
        Route::get('/order/history', 'orderhistory')->name('vendor.order.history');
    });

    Route::controller(SellerProductController::class)->group(function () {
        Route::get('/product/create', 'index')->name('vendor.product');
        Route::post('/product/create', 'storeproduct')->name('vendor.product.store');
        Route::get('/product/manage', 'manage')->name('vendor.product.manage');
    });

    Route::controller(SellerStoreController::class)->group(function () {
        Route::get('/store/create', 'index')->name('vendor.store');
        Route::get('/store/manage', 'manage')->name('vendor.store.manage');
        Route::post('/store/publish', 'store')->name('create.store');
    });
});

// Customer routes (mantêm restrição de autenticação e role)
Route::middleware(['auth', 'verified', 'rolemanager:customer'])->prefix('user')->group(function () {
    Route::controller(CustomerMainController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/order/history', 'history')->name('customer.history');
        Route::get('/setting/payment', 'payment')->name('customer.payment');
        Route::get('/affiliate', 'affiliate')->name('customer.affiliate');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
