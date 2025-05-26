<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\LockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LockerController;
use App\Http\Controllers\AppCardController;
use App\Http\Controllers\AppPageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CardTypeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GreetingController;
use App\Http\Controllers\LoginAppController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\AdminBillController;
use App\Http\Controllers\MessageAppContoller;
use App\Http\Controllers\ReadyCardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\AppLockersController;
use App\Http\Controllers\MessageAppController;
use App\Http\Controllers\ProfileAppController;
use App\Http\Controllers\CardContentController;
use App\Http\Controllers\RegisterAppController;
use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\ReadyCardItemController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\LocksWReadyCardController;
use App\Http\Controllers\PackagePurchaseController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
})->name('welcome');
Route::post('/users/{user}/verify-email', [UserController::class, 'verifyEmail'])->name('users.verify.email');
    Route::post('/users/{user}/verify-whatsapp', [UserController::class, 'verifyWhatsapp'])->name('users.verify.whatsapp');
    
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/app.php';

// Admin Settings Routes
Route::middleware(['admin.only'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('settings', SettingController::class);
    Route::resource('lockers', LockerController::class);
});

Route::middleware(['admin.only'])->group(function(){
        Route::resource('requests', RequestController::class);
        Route::resource('packages', PackageController::class);
        Route::get('packages/{package}/toggle-status', [PackageController::class, 'toggleStatus'])->name('packages.toggle.status');

   // Type-specific create routes
   Route::get('requests/create/lock', [RequestController::class, 'createLock'])->name('requests.create.lock');
   Route::get('requests/create/ready-card', [RequestController::class, 'createReadyCard'])->name('requests.create.ready-card');
   
   
   Route::post('requests/{request}/approve', [RequestController::class, 'approve'])->name('requests.approve');
        Route::post('requests/{request}/reject', [RequestController::class, 'reject'])->name('requests.reject');
        Route::post('requests/{request}/complete', [RequestController::class, 'markAsCompleted'])->name('requests.complete');
        Route::post('requests/{request}/status/{status}', [RequestController::class, 'updateStatus'])->name('requests.update.status');
    Route::get('/admin/dashboard',[DashboardController::class ,'index'])->name('dashboard.index');

    Route::resource('users', UserController::class);
    
    // Additional filter routes
    Route::get('users/type/{type}', [UserController::class, 'filterByType'])->name('users.filter.type');
    Route::get('users/status/{status}', [UserController::class, 'filterByStatus'])->name('users.filter.status');
    Route::get('users/country/{country}', [UserController::class, 'filterByCountry'])->name('users.filter.country');
    
    // User actions
    Route::get('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle.status');
    Route::get('users/{user}/block', [UserController::class, 'blockUser'])->name('users.block');
    Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');

    Route::get('api/users/{id}', [UserController::class, 'getUser'])->name('api.users.get');

    Route::resource('categories', CategoryController::class);
    
    // Additional filter routes
    Route::get('categories/type/{type}', [CategoryController::class, 'filterByType'])->name('categories.filter.type');
    Route::get('categories/status/{status}', [CategoryController::class, 'filterByStatus'])->name('categories.filter.status');
    Route::get('categories/parent/{parent}', [CategoryController::class, 'filterByParent'])->name('categories.filter.parent');
    
    // Toggle status route
    Route::get('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle.status');

    Route::resource('card_types', CardTypeController::class);
    
    // Additional filter routes
    Route::get('card_types/type/{type}', [CardTypeController::class, 'filterByType'])->name('card_types.filter.type');
    Route::get('card_types/status/{status}', [CardTypeController::class, 'filterByStatus'])->name('card_types.filter.status');
    
    // Toggle status route
    Route::get('card_types/{cardType}/toggle-status', [CardTypeController::class, 'toggleStatus'])->name('card_types.toggle.status');

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
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::get('/messages/{message}/edit', [MessageController::class, 'edit'])->name('messages.edit');
    Route::put('/messages/{message}', [MessageController::class, 'update'])->name('messages.update');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    
    // Additional custom routes

    Route::post('/messages/get-cards', [MessageController::class, 'getCards'])
        ->name('messages.get-cards');
    // In your routes/web.php
Route::post('/messages/{message}/resend', [MessageController::class, 'resendMessage'])->name('messages.resend');
    Route::post('/messages/{message}/send-manual', [MessageController::class, 'sendManual'])
        ->name('messages.send-manual');

        Route::resource('countries', \App\Http\Controllers\CountryController::class);

        Route::resource('locks_w_ready_cards', LocksWReadyCardController::class);
    
        // Additional filter routes
        Route::get('locks_w_ready_cards/type/{type}', [LocksWReadyCardController::class, 'filterByType'])->name('locks_w_ready_cards.filter.type');
        Route::get('locks_w_ready_cards/status/{status}', [LocksWReadyCardController::class, 'filterByStatus'])->name('locks_w_ready_cards.filter.status');
        
        // Toggle status route
        Route::get('locks_w_ready_cards/{locksWReadyCard}/toggle-status', [LocksWReadyCardController::class, 'toggleStatus'])->name('locks_w_ready_cards.toggle.status');


        Route::get('ready-cards/{readyCard}/items', [ReadyCardController::class, 'getItems'])->name('ready-cards.items');
        Route::post('ready-card-items/{item}/toggle-status', [ReadyCardItemController::class, 'toggleStatus'])->name('ready-card-items.toggle-status');
        Route::get('ready-card-items/{item}/print', [ReadyCardItemController::class, 'printCard'])->name('ready-card-items.print');
        Route::get('ready-cards/{readyCard}/print-all', [ReadyCardController::class, 'printAllCards'])->name('ready-cards.print-all');
    
        


        
});







Route::get('/subcategories-for-main', [App\Http\Controllers\MessageController::class, 'getSubCategories']);
Route::get('/cards-for-subcategory', [App\Http\Controllers\MessageController::class, 'getCards']);
Route::post('/verify-card-number', [App\Http\Controllers\MessageController::class, 'verifyCardNumber'])->name('verify-card-number');

Route::get('language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back()->with('locale_changed', true);
})->name('language.switch');
// Add these routes

// Add this to your routes/web.php file
});

// This should be at the very bottom of your routes file
Route::middleware(['language'])->group(function () {

Route::get('/{unique_identifier}', [CardContentController::class, 'showCardContent'])
    ->name('greetings.front.show');

    Route::post('/unlock-message-code/{id}', [CardContentController::class, 'unlockMessageCode'])->name('unlock.message.code');



Route::get('/message/{uniqueIdentifier}/respond', [CardContentController::class, 'showResponseForm'])->name('message.respond.form');
Route::post('/message/{uniqueIdentifier}/respond', [CardContentController::class, 'storeResponse'])->name('message.respond.store');
Route::get('/message/{uniqueIdentifier}/details', [CardContentController::class, 'showMessageDetails'])->name('message.details');



Route::prefix('whatsapp')->group(function () {
    Route::post('/send-templates', [WhatsAppController::class, 'sendTemplates'])->name('whatsapp.send-templates');
    Route::get('/test-connection', [WhatsAppController::class, 'testConnection'])->name('whatsapp.test-connection');
});



// Registration Routes with 'app' prefix and namespace


});



Route::middleware(['language'])->group(function () {

Route::middleware(['admin.only'])->prefix('admin')->group(function () {
    Route::get('/bills', [AdminBillController::class, 'index'])->name('admin.bills.index');


    Route::get('/bills/{bill}', [AdminBillController::class, 'show'])->name('admin.bills.show');
    Route::get('/bills/{bill}/pdf', [AdminBillController::class, 'generatePdf'])->name('admin.bills.pdf');
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('admin.payments.index');
});

});
Route::middleware(['admin.only'])->prefix('admin')->name('admin.')->group(function () {

Route::resource('pages', PageController::class);
});



Route::prefix('app')->name('app.')->group(function () {
    Route::get('/privacy', [AppPageController::class, 'privacy'])->name('privacy');
    Route::get('/terms', [AppPageController::class, 'terms'])->name('terms');
    Route::get('/benefits', [AppPageController::class, 'benefits'])->name('benefits');
    Route::get('/prices', [AppPageController::class, 'prices'])->name('prices');
    Route::get('/balances', [AppPageController::class, 'balances'])->name('balances');
    Route::get('/locks/page', [AppPageController::class, 'locks'])->name('locks');
    Route::get('/cards/page', [AppPageController::class, 'cards'])->name('cards');
});
Route::prefix('app')->name('app.')->group(function () {

Route::get('/{slug}', [AppPageController::class, 'showPage'])
    ->where('slug', '[a-z0-9-]+') // Basic slug validation
    ->name('dynamic.page');

});


