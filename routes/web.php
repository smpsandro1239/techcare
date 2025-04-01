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
use App\Http\Livewire\ProductCatalog;

// Rotas Públicas

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Catálogo e Produtos
Route::get('/catalogo', ProductCatalog::class,)->name('catalogo');
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
        Route::get('/order/history', 'order_history')->name('order.history');
        Route::get('/order/{order}', 'show')->name('order.show');
        Route::delete('/order/{order}', 'destroy')->name('order.destroy'); 
        Route::get('/order/{order}/edit', 'edit')->name('order.edit');
        Route::put('/order/{order}', 'update')->name('order.update');
        Route::post('/orders/{order}/assign', 'assign')->name('order.assign');
        Route::post('/agendamentos/{agendamento}/unassign','unassign')->name('order.unassign');
        Route::get('assigned-agendamentos', 'assignedAgendamentos')->name('assigned.agendamentos');
        Route::get('/assigned', 'assignedAgendamentos')->name('order.assigned');
        Route::get('/order/{order}/create-report','createReportForm')->name('order.create.report');
        Route::post('/order/{order}/generate-report', 'generateReport')->name('order.generate.report');
        Route::get('/order/{order}/reports', 'viewReports')->name('order.view.reports');
        Route::delete('/report/{report}', 'destroyReport')->name('report.delete');
        Route::post('/admin/agendamentos/{order}/atribuir','assignAgendamento')->name('agendamento.assign');
        Route::post('/admin/agendamentos/{order}/desatribuir', 'unassignAgendamento')->name('agendamento.unassign');
     
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
        Route::post('/orders/{order}/assign', 'assign')->name('order.assign');
        Route::post('/agendamentos/{agendamento}/unassign','unassign')->name('order.unassign');
        Route::get('assigned-agendamentos', 'assignedAgendamentos')->name('assigned.agendamentos');
        Route::get('/assigned', 'assignedAgendamentos')->name('order.assigned');
        Route::get('/order/{order}/create-report','createReportForm')->name('order.create.report');
        Route::post('/order/{order}/generate-report', 'generateReport')->name('order.generate.report');
        Route::get('/order/{order}/reports', 'viewReports')->name('order.view.reports');
        Route::delete('/report/{report}', 'destroyReport')->name('report.delete');
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
        Route::get('admin/order/{order}', 'show')->name('order.show');
        Route::delete('admin/order/{order}', 'destroy')->name('order.destroy');
        Route::get('user/order/{order}/edit', 'edit')->name('order.edit');
        Route::put('user/order/{order}', 'update')->name('order.update');
        Route::get('/customer/order/{order}/reports', 'showReports')->name('order.reports');    
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
