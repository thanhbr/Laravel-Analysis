<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Api\PermissionsController;
use App\Http\Controllers\Admin\PermissionRoleController;
use App\Http\Controllers\Api\PermissionRolesController;
use App\Http\Controllers\Api\BannersController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Api\InventoriesController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Api\BrandsController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Api\InvoicesController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Api\CustomersController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Api\CommentsController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [UserController::class, 'index'])->name('login');
Route::get('/app/login', [UserController::class, 'index']);
Route::get('/slogin', [UserController::class, 'index']);
Route::get('/user/login', [UserController::class, 'index']);
Route::post('/user/do-login', [UserController::class, 'doLogin']);
Route::post('/logout', [UserController::class, 'destroy']);

// Admin site routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/app/dashboard', [DashboardController::class, 'index']);

    Route::get('/app/category', [CategoryController::class, 'index']);
    Route::get('/internal/categories/get/{id?}', [CategoriesController::class, 'get']);
    Route::get('/internal/categories/get-parent-list', [CategoriesController::class, 'getParentList']);
    Route::post('/internal/categories/add', [CategoriesController::class, 'add']);
    Route::post('/internal/categories/update', [CategoriesController::class, 'update']);
    Route::post('/internal/categories/delete/{id}', [CategoriesController::class, 'delete']);

    Route::get('/app/banner', [BannerController::class, 'index']);
    Route::get('/internal/banners/get/{id?}', [BannersController::class, 'get']);
    Route::post('/internal/banners/add', [BannersController::class, 'add']);
    Route::post('/internal/banners/update', [BannersController::class, 'update']);
    Route::post('/internal/banners/delete/{id}', [BannersController::class, 'delete']);

    Route::get('/app/inventory', [InventoryController::class, 'index']);
    Route::get('/internal/inventories/get/{id?}', [InventoriesController::class, 'get']);
    Route::post('/internal/inventories/add', [InventoriesController::class, 'add']);
    Route::post('/internal/inventories/update', [InventoriesController::class, 'update']);
    Route::post('/internal/inventories/delete/{id}', [InventoriesController::class, 'delete']);

    Route::get('/app/brand', [BrandController::class, 'index']);
    Route::get('/internal/brands/get/{id?}', [BrandsController::class, 'get']);
    Route::post('/internal/brands/add', [BrandsController::class, 'add']);
    Route::post('/internal/brands/update', [BrandsController::class, 'update']);
    Route::post('/internal/brands/delete/{id}', [BrandsController::class, 'delete']);

    Route::get('/app/product', [ProductController::class, 'index']);
    Route::get('/internal/products/get/{id?}', [ProductsController::class, 'get']);
    Route::post('/internal/products/add', [ProductsController::class, 'add']);
    Route::post('/internal/products/update', [ProductsController::class, 'update']);
    Route::post('/internal/products/delete/{id}', [ProductsController::class, 'delete']);

    Route::get('/app/invoice', [InvoiceController::class, 'index']);
    Route::get('/internal/invoices/get/{id?}', [InvoicesController::class, 'get']);
    Route::post('/internal/invoices/add', [InvoicesController::class, 'add']);
    Route::post('/internal/invoices/update', [InvoicesController::class, 'update']);
    Route::post('/internal/invoices/delete/{id}', [InvoicesController::class, 'delete']);

    Route::get('/app/customer', [CustomerController::class, 'index']);
    Route::get('/internal/customers/get/{id?}', [CustomersController::class, 'get']);
    Route::post('/internal/customers/add', [CustomersController::class, 'add']);
    Route::post('/internal/customers/update', [CustomersController::class, 'update']);
    Route::post('/internal/customers/delete/{id}', [CustomersController::class, 'delete']);

    Route::get('/app/comment', [CommentController::class, 'index']);
    Route::get('/internal/comments/get/{id?}', [CommentsController::class, 'get']);
    Route::post('/internal/comments/add', [CommentsController::class, 'add']);
    Route::post('/internal/comments/update', [CommentsController::class, 'update']);
    Route::post('/internal/comments/delete/{id}', [CommentsController::class, 'delete']);

    Route::get('/app/role', [RoleController::class, 'index']);
    Route::get('/internal/roles/get/{id?}', [RolesController::class, 'get']);
    Route::post('/internal/roles/add', [RolesController::class, 'add']);
    Route::post('/internal/roles/update', [RolesController::class, 'update']);
    Route::post('/internal/roles/delete/{id}', [RolesController::class, 'delete']);

    Route::get('/app/permission', [PermissionController::class, 'index']);
    Route::get('/internal/permissions/get/{id?}', [PermissionsController::class, 'get']);
    Route::post('/internal/permissions/add', [PermissionsController::class, 'add']);
    Route::post('/internal/permissions/update', [PermissionsController::class, 'update']);
    Route::post('/internal/permissions/delete/{id}', [PermissionsController::class, 'delete']);

    Route::get('/app/permission-role', [PermissionRoleController::class, 'index']);
    Route::get('/internal/permission-roles/get/{id?}', [PermissionRolesController::class, 'get']);
    Route::post('/internal/permission-roles/add', [PermissionRolesController::class, 'add']);
    Route::post('/internal/permission-roles/update', [PermissionRolesController::class, 'update']);
    Route::post('/internal/permission-roles/delete/{id}', [PermissionRolesController::class, 'delete']);

    Route::get('/app/user', [UserController::class, 'indexUser']);
    Route::get('/internal/users/get/{id?}', [UsersController::class, 'get']);
    Route::post('/internal/users/add', [UsersController::class, 'add']);
    Route::post('/internal/users/update', [UsersController::class, 'update']);
    Route::post('/internal/users/delete/{id}', [UsersController::class, 'delete']);
});
