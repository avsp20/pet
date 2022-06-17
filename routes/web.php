<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FrontUserController;
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

// Main Page Route
Route::get('/', function(){
    return redirect()->route('auth-login');
});


Route::group(['prefix' => 'user'], function () {
    Route::resource('user','App\Http\Controllers\FrontUserController');
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
        Route::get('register', [FrontUserController::class, 'userRegister'])->name('user-register');
        Route::post('login', [FrontUserController::class, 'login'])->name('login');
        Route::get('login', [AuthenticationController::class, 'login_cover'])->name('auth-login');
    });
});
Route::group(['prefix' => 'user', 'middleware' => 'auth', 'auth_user'], function () {
    Route::get('dashboard', [FrontUserController::class, 'userDashboard'])->name('user-dashboard');
    Route::get('customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.front-edit');
    Route::get('customers/pets/create/{id}',[CustomerController::class, 'createCustomerPets'])->name('user-pet-create');
    Route::get('customers/edit-pet/{id}',[CustomerController::class, 'editCustomerPetDetails'])->name('user-pet-edit');
});
/* Route Dashboards */
Route::group(['prefix' => 'admin'], function () {
    // New routes start
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
        // Route::get('login', [AuthenticationController::class, 'login_cover'])->name('auth-login');
        Route::get('login', [AuthenticationController::class, 'login_cover']);
        Route::post('login', [AuthenticationController::class, 'login'])->name('login');
        Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
        Route::get('forgot-password', [AuthenticationController::class, 'forgot_password_cover'])->name('auth-forgot-password');
        Route::post('reset-password-email', [AuthenticationController::class, 'reset_password_cover'])->name('auth-reset-password-email');
        Route::get('password/reset/{token}', [AuthenticationController::class, 'showResetForm'])->name('auth-reset-password');
        Route::post('reset-password', [AuthenticationController::class, 'resetPassword'])->name('auth-reset-password-update');
    });
});
/* Route Dashboards */
Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'auth_admin'], function () {
    Route::get('dashboard', [DashboardController::class, 'dashboardAnalytics'])->name('dashboard');
    Route::get('customer-list',[DashboardController::class, 'customerList'])->name('customer-list');
    Route::resource('customers', 'App\Http\Controllers\CustomerController');
    Route::get('customers/pets/{id}',[CustomerController::class, 'customerPetDetails'])->name('customers-pets');
    Route::get('customers/edit-pet/{id}',[CustomerController::class, 'editCustomerPetDetails'])->name('customers-pet-edit');
    Route::get('pet-processing',[CustomerController::class, 'petProcessingChecklist'])->name('pet-processing');
    Route::get('pet-processing/{id}', [CustomerController::class, 'editPetProcessing'])->name('edit-pet-processing');
    Route::post('update-pet-processing/{id}', [CustomerController::class, 'updatePetProcessing'])->name('update-pet-processing');
    Route::get('generate-certificate/{id}', [CustomerController::class, 'generatePetCremationCertificate'])->name('generate-certificate');
    Route::get('pet-processing-checklist/{id}',[CustomerController::class, 'petProcessingStatus'])->name('pet-processing-checklist');

    Route::post('store-customer-pet/{id}', [CustomerController::class, 'storeCustomerPets'])->name('store-customer-pet');
    Route::post('update-customer-pet/{id}', [CustomerController::class, 'updateCustomerPets'])->name('update-customer-pet');
    Route::get('customers/pets/create/{id}',[CustomerController::class, 'createCustomerPets'])->name('customers-pet-create');
    Route::delete('customers/pets/{id}',[CustomerController::class, 'deleteCustomerPet'])->name('customers-pet-delete');

    Route::resource('businesses', 'App\Http\Controllers\BusinessUserController');
    Route::get('calendar', [AppsController::class, 'calendarApp'])->name('app-calendar');
    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('edit-profile', [DashboardController::class, 'editProfile'])->name('edit-profile');
    Route::get('change-password', [DashboardController::class, 'changePassword'])->name('change-password');
    Route::post('change-password', [DashboardController::class, 'userChangePassword'])->name('change-password-update');
    Route::resource('users', 'App\Http\Controllers\UserController');

    Route::resource('urn-display', 'App\Http\Controllers\UrnDisplayController');

    Route::get('view-certificate', [CustomerController::class, 'viewCertificate'])->name('view-certificate');
    // Route::get('account-settings-account', [PagesController::class, 'account_settings_account'])->name('page-account-settings-account');
});

