<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\LockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CardTypeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReadyCardController;
use App\Http\Controllers\ReadyCardItemController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['language'])->group(function () {
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// User routes
Route::middleware(['auth'])->group(function () {
    // Basic CRUD routes
    Route::resource('users', UserController::class);
    
    // Additional filter routes
    Route::get('users/type/{type}', [UserController::class, 'filterByType'])->name('users.filter.type');
    Route::get('users/status/{status}', [UserController::class, 'filterByStatus'])->name('users.filter.status');
    Route::get('users/country/{country}', [UserController::class, 'filterByCountry'])->name('users.filter.country');
    
    // User actions
    Route::get('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle.status');
    Route::get('users/{user}/block', [UserController::class, 'blockUser'])->name('users.block');
    Route::get('users/{user}/verify-email', [UserController::class, 'verifyEmail'])->name('users.verify.email');
    Route::get('users/{user}/verify-whatsapp', [UserController::class, 'verifyWhatsapp'])->name('users.verify.whatsapp');
    
    // API route for getting user data
    Route::get('api/users/{id}', [UserController::class, 'getUser'])->name('api.users.get');

    Route::resource('categories', CategoryController::class);
    
    // Additional filter routes
    Route::get('categories/type/{type}', [CategoryController::class, 'filterByType'])->name('categories.filter.type');
    Route::get('categories/status/{status}', [CategoryController::class, 'filterByStatus'])->name('categories.filter.status');
    Route::get('categories/parent/{parent}', [CategoryController::class, 'filterByParent'])->name('categories.filter.parent');
    
    // Toggle status route
    Route::get('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle.status');
});

Route::get('/admin/dashboard',[DashboardController::class ,'index'])->name('dashboard.index');
Route::middleware(['auth'])->group(function () {
    // Basic CRUD routes
    Route::resource('card_types', CardTypeController::class);
    
    // Additional filter routes
    Route::get('card_types/type/{type}', [CardTypeController::class, 'filterByType'])->name('card_types.filter.type');
    Route::get('card_types/status/{status}', [CardTypeController::class, 'filterByStatus'])->name('card_types.filter.status');
    
    // Toggle status route
    Route::get('card_types/{cardType}/toggle-status', [CardTypeController::class, 'toggleStatus'])->name('card_types.toggle.status');
});


// Card routes
Route::middleware(['auth'])->group(function () {
    // Basic CRUD routes
    Route::resource('cards', CardController::class);
    Route::resource('locks', LockController::class);
Route::post('locks/{lock}/toggle-status', [LockController::class, 'toggleStatus'])->name('locks.toggle.status');
Route::get('locks/filter/status/{status}', [LockController::class, 'filterByStatus'])->name('locks.filter.status');
Route::get('locks/filter/stock/{status}', [LockController::class, 'filterByStock'])->name('locks.filter.stock');
Route::get('locks/filter/supplier/{supplier}', [LockController::class, 'filterBySupplier'])->name('locks.filter.supplier');
Route::post('locks/{lock}/adjust-quantity', [LockController::class, 'adjustQuantity'])->name('locks.adjust.quantity');
    // Additional filter routes

    // Ready Card Management Routes
Route::resource('ready-cards', ReadyCardController::class);
Route::get('ready-cards/filter/customer/{customerId}', [ReadyCardController::class, 'filterByCustomer'])->name('ready_cards.filter.customer');
Route::post('ready-cards/filter/date', [ReadyCardController::class, 'filterByDate'])->name('ready_cards.filter.date');


    Route::get('cards/type/{cardType}', [CardController::class, 'filterByType'])->name('cards.filter.type');
    Route::get('cards/main-category/{mainCategory}', [CardController::class, 'filterByMainCategory'])->name('cards.filter.main-category');
    Route::get('cards/sub-category/{subCategory}', [CardController::class, 'filterBySubCategory'])->name('cards.filter.sub-category');
    Route::get('cards/designer/{user}', [CardController::class, 'filterByDesigner'])->name('cards.filter.designer');
    Route::get('cards/language/{language}', [CardController::class, 'filterByLanguage'])->name('cards.filter.language');
    Route::get('cards/status/{status}', [CardController::class, 'filterByStatus'])->name('cards.filter.status');
    
    // Toggle status route
    Route::get('cards/{card}/toggle-status', [CardController::class, 'toggleStatus'])->name('cards.toggle.status');
    
    // Get subcategories for a main category (for AJAX)
    Route::get('get-subcategories/{mainCategory}', [CardController::class, 'getSubcategories'])->name('cards.get-subcategories');
});

Route::get('language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back()->with('locale_changed', true);
})->name('language.switch');
// Add these routes
Route::get('ready-cards/{readyCard}/items', [ReadyCardController::class, 'getItems'])->name('ready-cards.items');
Route::post('ready-card-items/{item}/toggle-status', [ReadyCardItemController::class, 'toggleStatus'])->name('ready-card-items.toggle-status');
Route::get('ready-card-items/{item}/print', [ReadyCardItemController::class, 'printCard'])->name('ready-card-items.print');
Route::get('ready-cards/{readyCard}/print-all', [ReadyCardController::class, 'printAllCards'])->name('ready-cards.print-all');
});
