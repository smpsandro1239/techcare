<?php

use App\Http\Controllers\Admin\AdminMainController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\Customer\CustomerMainController;
use App\Http\Controllers\MasterCategoryController;
use App\Http\Controllers\MasterSubCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\SellerMainController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Livewire\ProductCatalog;

// Rotas Públicas
// -----------------

// Página inicial
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Catálogo e Produtos
Route::get('/catalogo', ProductCatalog::class)->name('catalogo');
Route::get('/product/procurar', [ProductController::class, 'procurar'])->name('product.procurar');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// Agendamentos (acessíveis por todos)
Route::prefix('agendamento')->name('agendamento.')->group(function () {
    Route::controller(AgendamentoController::class)->group(function () {
        Route::get('/', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/lista', 'index')->name('index');
        Route::get('/json', 'getAgendamentos')->name('json');
    });
});

// Rotas Protegidas por Autenticação
// ---------------------------------

// Rotas do Administrador
Route::middleware(['auth', 'verified', 'rolemanager:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard e Configurações
    Route::controller(AdminMainController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/settings', 'setting')->name('settings');
        Route::get('/manage/users', 'manage_user')->name('manage.user');
        Route::get('/manage/stores', 'manage_stores')->name('manage.store');
        Route::get('/cart/history', 'cart_history')->name('cart.history');
        Route::get('/order/history', 'order_history')->name('order.history');
    });

    // Categorias
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category/create', 'index')->name('category.create');
        Route::get('/category/manage', 'manage')->name('category.manage');
        Route::post('/category/store', 'store')->name('category.store');
    });

    // Subcategorias
    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('/subcategory/create', 'index')->name('subcategory.create');
        Route::get('/subcategory/manage', 'manage')->name('subcategory.manage');
        Route::post('/subcategory/store', 'store')->name('subcategory.store');
    });

    // Produtos
    Route::controller(AdminProductController::class)->group(function () {
        Route::get('/product/manage', 'index')->name('product.index');
        Route::get('/product/create', 'create')->name('product.create');
        Route::post('/product/store', 'store')->name('product.store');
        Route::get('/product/edit/{id}', 'edit')->name('product.edit');
        Route::put('/product/update/{id}', 'update')->name('product.update');
        Route::delete('/product/destroy/{id}', 'destroy')->name('product.destroy');
        Route::get('/product/review/manage', 'review_manage')->name('product.review.manage');
    });

    // Atributos de Produto
    Route::controller(ProductAttributeController::class)->group(function () {
        Route::get('/product_attribute/create', 'index')->name('product_attribute.create');
        Route::get('/product_attribute/manage', 'manage')->name('product_attribute.manage');
        Route::post('/product_attribute/create', 'createattribute')->name('product_attribute.create');
        Route::get('/product_attribute/edit/{id}', 'showattribute')->name('product_attribute.edit');
        Route::post('/product_attribute/update/{id}', 'updateattribute')->name('product_attribute.update');
        Route::delete('/product_attribute/delete/{id}', 'deleteattribute')->name('product_attribute.delete');
    });

    // Master Category
    Route::controller(MasterCategoryController::class)->group(function () {
        Route::post('/store/category', 'storecat')->name('category.store');
        Route::get('/category/{id}', 'showcat')->name('category.show');
        Route::put('/category/update/{id}', 'updatecat')->name('category.update');
        Route::delete('/category/delete/{id}', 'deletecat')->name('category.delete');
    });

    // Master Subcategory
    Route::controller(MasterSubCategoryController::class)->group(function () {
        Route::post('/store/subcategory', 'storesubcat')->name('subcategory.store');
        Route::get('/subcategory/{id}', 'showsubcat')->name('subcategory.show');
        Route::put('/subcategory/update/{id}', 'updatesubcat')->name('subcategory.update');
        Route::delete('/subcategory/delete/{id}', 'deletesubcat')->name('subcategory.delete');
    });

    Route::controller(AgendamentoController::class)->group(function () {
        Route::get('agendamento/create', 'create')->name('admin.agendamento.create');
        Route::post('/', 'store')->name('admin.agendamento.store');
        Route::get('/lista', 'index')->name('admin.agendamento.index');
    });
});

// Rotas do Vendedor
Route::middleware(['auth', 'verified', 'rolemanager:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    // Dashboard
    Route::controller(SellerMainController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/order/history', 'orderhistory')->name('order.history');
    });

    // Produtos
    Route::controller(SellerProductController::class)->group(function () {
        Route::get('/product/create', 'index')->name('product.create');
        Route::post('/product/create', 'storeproduct')->name('product.store');
        Route::get('/product/manage', 'manage')->name('product.manage');
        Route::get('/product/edit/{id}', 'edit')->name('product.edit');
        Route::post('/product/update/{id}', 'update')->name('product.update');
        Route::delete('/product/destroy/{id}', 'destroy')->name('product.destroy');
    });
});

// Rotas do Cliente
Route::middleware(['auth', 'verified', 'rolemanager:customer'])->prefix('user')->name('user.')->group(function () {
    Route::controller(CustomerMainController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/order/history', 'history')->name('order.history');
        Route::get('/setting/payment', 'payment')->name('setting.payment');
        Route::get('/affiliate', 'affiliate')->name('affiliate');
    });

    Route::controller(AgendamentoController::class)->group(function () {
        Route::get('agendamento/create', 'create')->name('customer.agendamento.create');
        Route::post('/', 'store')->name('agendamento.store');
        Route::get('/lista', 'index')->name('agendamento.index');
    });
});

// Rotas de Perfil (comuns a todos os usuários autenticados)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::put('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

require __DIR__ . '/auth.php';