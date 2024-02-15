<?php

use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Livewire\Admin\CategoryComponent;
use App\Http\Livewire\Admin\DebtComponent;
use App\Http\Livewire\Admin\InvoiceComponent;
use App\Http\Livewire\Admin\PosComponent;
use App\Http\Livewire\Admin\ProductComponent;
use App\Http\Livewire\Admin\ResellerComponent;
use App\Http\Livewire\Admin\SaleComponent;
use App\Http\Livewire\Admin\StoreComponent;
use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\SignUp;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Billing;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Tables;
use App\Http\Livewire\StaticSignIn;
use App\Http\Livewire\StaticSignUp;
use App\Http\Livewire\Rtl;

use App\Http\Livewire\LaravelExamples\UserProfile;
use App\Http\Livewire\LaravelExamples\UserManagement;
use App\Http\Middleware\Admin\ResselerComponent;
use Illuminate\Http\Request;

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
    return redirect('/login');
});

Route::get('/sign-up', SignUp::class)->name('sign-up');
Route::get('/login', Login::class)->name('login');

Route::get('/login/forgot-password', ForgotPassword::class)->name('forgot-password');

Route::get('/reset-password/{id}', ResetPassword::class)->name('reset-password')->middleware('signed');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/billing', Billing::class)->name('billing');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/tables', Tables::class)->name('tables');
    Route::get('/static-sign-in', StaticSignIn::class)->name('sign-in');
    Route::get('/static-sign-up', StaticSignUp::class)->name('static-sign-up');
    Route::get('/rtl', Rtl::class)->name('rtl');
    Route::get('/user-profile', UserProfile::class)->name('user-profile');
    Route::get('/user-management', UserManagement::class)->name('user-management');


    // Store Crud
    Route::get('/stores', StoreComponent::class)->name('stores');

    // POS
    Route::get('/pos', PosComponent::class)->name('pos');
    
    // Debts
    Route::get('/debts', DebtComponent::class)->name('debts');

    // Reseller Crud
    Route::get('/resellers', ResellerComponent::class)->name('resellers');

    // Category Crud
    Route::get('/categories', CategoryComponent::class)->name('categories');

    // Product Crud
    Route::get('/products', ProductComponent::class)->name('products');


    // invoice
    Route::get('/invoice/{id}', [InvoiceController::class, 'index'])->name('invoice');

    // sales
    Route::get('/sales', SaleComponent::class)->name('sales');
});
