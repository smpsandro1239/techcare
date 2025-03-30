<?php

use App\Http\Controllers\Admin\AdminMainController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\Customer\CustomerMainController;
use App\Http\Controllers\MasterCategoryController;
use App\Http\Controllers\MasterSubCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\SellerMainController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerCategoryController;
use App\Http\Controllers\Seller\SellerSubCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ProductCatalog; // Namespace corrigido

// Rotas Públicas

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
Route::middleware(['auth', 'verified', 'rolemanager:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::controller(AdminMainController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/settings', 'setting')->name('settings');
        Route::get('/manage/users', 'manage_user')->name('manage.user');
        Route::get('/manage/stores', 'manage_stores')->name('manage.store');
        Route::get('/cart/history', 'cart_history')->name('cart.history');
        Route::get('/order/history', 'order_history')->name('order.history');
        Route::get('admin/order/{order}', 'show')->name('order.show');
        Route::delete('admin/order/{order}', 'destroy')->name('order.destroy'); // Rota para deletar um agendamento
        Route::get('admin/order/{order}/edit', 'edit')->name('order.edit');
        Route::put('admin/order/{order}', 'update')->name('order.update');        
    });


    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category/create', 'index')->name('category.create');
        Route::get('/category/manage', 'manage')->name('category.manage');
        Route::post('/category/store', 'store')->name('category.store');
    });


    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('/subcategory/create', 'index')->name('subcategory.create');
        Route::get('/subcategory/manage', 'manage')->name('subcategory.manage');
        Route::post('/subcategory/store', 'store')->name('subcategory.store');
    });


    Route::controller(ProductController::class)->group(function () {
        Route::get('/product/create', 'create')->name('product.create');
        Route::post('/product/create', 'storeproduct')->name('product.store');
        Route::get('/product/manage', 'manage')->name('product.manage');
        Route::get('/product/edit/{id}', 'edit')->name('product.edit');
        Route::put('/product/update/{id}', 'update')->name('product.update');
        Route::delete('/product/destroy/{id}', 'destroy')->name('product.destroy');
    });


    Route::controller(MasterCategoryController::class)->group(function () {
        Route::post('/store/category', 'storecat')->name('admin.mastercategory.store');
        Route::get('/category/{id}', 'showcatAdmin')->name('category.show');
        Route::put('/category/update/{id}', 'updatecat')->name('category.update');
        Route::delete('/category/delete/{id}', 'deletecat')->name('category.delete');
    });


    Route::controller(MasterSubCategoryController::class)->group(function () {
        Route::post('/store/subcategory', 'storesubcat')->name('admin.mastersubcategory.store');
        Route::get('/subcategory/{id}', 'showsubcatAdmin')->name('subcategory.show');
        Route::put('/subcategory/update/{id}', 'updatesubcat')->name('subcategory.update');
        Route::delete('/subcategory/delete/{id}', 'deletesubcat')->name('subcategory.delete');
    });


    Route::controller(AgendamentoController::class)->group(function () {
        Route::get('agendamento/create', 'create')->name('agendamento.create');
        Route::post('/agendamento', 'store')->name('agendamento.store');
        Route::get('/agendamento/lista', 'index')->name('agendamento.index');
    });
});


Route::middleware(['auth', 'verified', 'rolemanager:vendor'])->prefix('vendor')->name('vendor.')->group(function () {

    Route::controller(SellerMainController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/order/history', 'order_history')->name('order.history');
        Route::get('/order/{order}', 'show')->name('order.show');
        Route::delete('/order/{order}', 'destroy')->name('order.destroy'); 
        Route::get('/order/{order}/edit', 'edit')->name('order.edit');
        Route::put('/order/{order}', 'update')->name('order.update');        
    });


    Route::controller(SellerProductController::class)->group(function () {
        Route::get('/product/create', 'create')->name('product.create');
        Route::post('/product/create', 'storeproduct')->name('product.store');
        Route::get('/product/manage', 'manage')->name('product.manage');
        Route::get('/product/edit/{id}', 'edit')->name('product.edit');
        Route::put('/product/update/{id}', 'update')->name('product.update');
        Route::delete('/product/destroy/{id}', 'destroy')->name('product.destroy');
    });

    Route::controller(SellerCategoryController::class)->group(function () {
        Route::get('/category/create', 'index')->name('category.create');
        Route::get('/category/manage', 'manage')->name('category.manage');
        Route::post('/category/store', 'store')->name('category.store');
    });

    Route::controller(SellerSubCategoryController::class)->group(function () {
        Route::get('/subcategory/create', 'index')->name('subcategory.create');
        Route::get('/subcategory/manage', 'manage')->name('subcategory.manage');
        Route::post('/subcategory/store', 'store')->name('subcategory.store');
    });

    Route::controller(AgendamentoController::class)->group(function () {
        Route::get('/agendamento/create', 'create')->name('agendamento.create');
        Route::post('/agendamento', 'store')->name('agendamento.store');
        Route::get('/agendamento/lista', 'index')->name('agendamento.index');
    });

    Route::controller(MasterCategoryController::class)->group(function () {
        Route::post('/store/category', 'storecat')->name('admin.mastercategory.store');
        Route::get('/category/{id}', 'showcatVendor')->name('category.show');
        Route::put('/category/update/{id}', 'updatecat')->name('category.update');
        Route::delete('/category/delete/{id}', 'deletecat')->name('category.delete');
    });


    Route::controller(MasterSubCategoryController::class)->group(function () {
        Route::post('/store/subcategory', 'storesubcat')->name('admin.mastersubcategory.store');
        Route::get('/subcategory/{id}', 'showsubcatVendor')->name('subcategory.show');
        Route::put('/subcategory/update/{id}', 'updatesubcat')->name('subcategory.update');
        Route::delete('/subcategory/delete/{id}', 'deletesubcat')->name('subcategory.delete');
    });
});

Route::middleware(['auth', 'verified', 'rolemanager:customer'])->prefix('user')->name('user.')->group(function () {
    Route::controller(CustomerMainController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/order/history', 'order_history')->name('order.history');
        Route::get('/setting/payment', 'payment')->name('setting.payment');
        Route::get('/affiliate', 'affiliate')->name('affiliate');
        Route::get('admin/order/{order}', 'show')->name('order.show');
        Route::delete('admin/order/{order}', 'destroy')->name('order.destroy');
        Route::get('user/order/{order}/edit', 'edit')->name('order.edit');
        Route::put('user/order/{order}', 'update')->name('order.update');        
    });

    Route::controller(AgendamentoController::class)->group(function () {
        Route::get('agendamento/create', 'create')->name('agendamento.create');
        Route::post('/agendamento', 'store')->name('agendamento.store');
        Route::get('/agendamento/lista', 'index')->name('agendamento.index');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [ProfileController::class, 'index'])->name('profile');
    Route::post('/perfil/atualizar', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/perfil/senha', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

require __DIR__ . '/auth.php';
