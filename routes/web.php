<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\LockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CardTypeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GreetingController;
use App\Http\Controllers\LoginAppController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\MessageAppContoller;
use App\Http\Controllers\ReadyCardController;
use App\Http\Controllers\MessageAppController;
use App\Http\Controllers\ProfileAppController;
use App\Http\Controllers\CardContentController;
use App\Http\Controllers\RegisterAppController;
use App\Http\Controllers\RegisterUserController;
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



// Messages Routes
Route::middleware(['auth'])->group(function () {
    // Resourceful routes
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
});
// Add this to routes/web.php for testing
Route::get('/test-subcategories', function(Illuminate\Http\Request $request) {
    $mainCategoryId = $request->input('main_category_id');
    $subCategories = App\Models\Category::where('parent_id', $mainCategoryId)
        ->get(['id', 'name_ar', 'name_en']);
    return response()->json($subCategories);
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
Route::resource('countries', \App\Http\Controllers\CountryController::class);

Route::get('ready-cards/{readyCard}/items', [ReadyCardController::class, 'getItems'])->name('ready-cards.items');
Route::post('ready-card-items/{item}/toggle-status', [ReadyCardItemController::class, 'toggleStatus'])->name('ready-card-items.toggle-status');
Route::get('ready-card-items/{item}/print', [ReadyCardItemController::class, 'printCard'])->name('ready-card-items.print');
Route::get('ready-cards/{readyCard}/print-all', [ReadyCardController::class, 'printAllCards'])->name('ready-cards.print-all');
});

// This should be at the very bottom of your routes file
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
Route::prefix('app')->name('app.')->group(function () {
    // Registration flow
    Route::get('/register', [RegisterAppController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterAppController::class, 'submitRegistrationForm']);

    Route::get('/register/phone', [RegisterAppController::class, 'showPhoneForm'])->name('register.phone');
    Route::post('/register/phone', [RegisterAppController::class, 'submitPhoneForm']);

    Route::get('/register/otp', [RegisterAppController::class, 'showOtpForm'])->name('register.otp');
    Route::post('/register/otp', [RegisterAppController::class, 'verifyOtp']);
    Route::post('/register/otp/resend', [RegisterAppController::class, 'resendOtp'])->name('register.otp.resend');

    Route::get('/register/password', [RegisterAppController::class, 'showPasswordForm'])->name('register.password');
    Route::post('/register/password', [RegisterAppController::class, 'completeRegistration']);

    Route::get('/register/complete', [RegisterAppController::class, 'showCompletePage'])->name('register.complete');
});

Route::prefix('app')->name('app.')->group(function () {
    // Login routes
    Route::get('/login', [LoginAppController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginAppController::class, 'login']);
    Route::post('/logout', [LoginAppController::class, 'logout'])->name('logout');
    
    // Forgot password routes
    Route::get('/forgot-password', [LoginAppController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('/forgot-password', [LoginAppController::class, 'forgotPassword'])->name('forgot-password.post');

});
// Routes that require authentication
Route::middleware(['auth'])->prefix('app')->name('app.')->group(function () {
    // Home route
    Route::get('/home', function() {
        return view('app.home');
    })->name('home');
    
    // Placeholder for new message route
    Route::get('/message/new', function() {
        // This is a placeholder, you'll implement this later
        return view('app.message.new');
    })->name('new-message');
    
    // Placeholder for dashboard route
    Route::get('/dashboard', function() {
        // This is a placeholder, you'll implement this later
        return view('app.dashboard');
    })->name('dashboard');
});

// Protected routes (require authentication)
Route::middleware(['auth'])->prefix('app')->name('app.')->group(function () {
    // Messages routes
    Route::get('/messages/create', [MessageAppController::class, 'create'])->name('messages.create');
    
    // API routes for AJAX
    Route::get('/subcategories/{mainCategoryId}', [MessageAppController::class, 'getSubcategories']);

    Route::get('/cards', [MessageAppController::class, 'getCards']);


});

Route::middleware(['auth'])->prefix('app/messages')->group(function () {
    // Step 1: Basic Information
    Route::get('/create/step1', [MessageAppController::class, 'createStep1'])->name('app.messages.create.step1');
    Route::post('/create/step1', [MessageAppController::class, 'postStep1'])->name('app.messages.post.step1');
    
    // Step 2: Card Selection
    Route::get('/create/step2', [MessageAppController::class, 'createStep2'])->name('app.messages.create.step2');
    Route::post('/create/step2', [MessageAppController::class, 'postStep2'])->name('app.messages.post.step2');
    
    // Step 3: Recipient Information
    Route::get('/create/step3', [MessageAppController::class, 'createStep3'])->name('app.messages.create.step3');
    Route::post('/create/step3', [MessageAppController::class, 'postStep3'])->name('app.messages.post.step3');
    
    // Step 4: Review
    Route::get('/create/step4', [MessageAppController::class, 'createStep4'])->name('app.messages.create.step4');
    
    // Final Submission
    Route::post('/store', [MessageAppController::class, 'store'])->name('app.messages.store');
    
    // Step 5: Success/Completion
    Route::get('/create/step5/{message_id}', [MessageAppController::class, 'createStep5'])->name('app.messages.create.step5');
    
    // AJAX routes for dynamic loading
    Route::get('/subcategories/{mainCategoryId}', [MessageAppController::class, 'getSubcategories'])->name('app.messages.subcategories');
    Route::get('/cards', [MessageAppController::class, 'getCards'])->name('app.messages.cards');
});


Route::middleware(['auth'])->prefix('app')->name('app.')->group(function () {
    Route::get('/profile', [ProfileAppController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileAppController::class, 'update'])->name('profile.update');
    Route::get('/profile/delete-confirmation', [ProfileAppController::class, 'showDeleteConfirmation'])->name('profile.delete-confirmation');
    Route::delete('/profile/delete', [ProfileAppController::class, 'deleteAccount'])->name('profile.delete');
    Route::get('/profile/change-password', [ProfileAppController::class, 'showChangePasswordForm'])->name('profile.change-password');
    Route::put('/profile/change-password', [ProfileAppController::class, 'updatePassword'])->name('profile.update-password');

    Route::get('/greetings', [GreetingController::class, 'index'])->name('greetings.index');
    Route::get('/greetings/{id}', [GreetingController::class, 'show'])->name('greetings.show');
    Route::get('/greetings/{id}/card', [GreetingController::class, 'showCard'])->name('greetings.show-card');
    Route::get('/greetings/{id}/response', [GreetingController::class, 'showResponse'])->name('greetings.show-response');
    Route::get('/greetings/{id}/private', [GreetingController::class, 'showPrivateMessage'])->name('greetings.private-message');
    Route::get('/greetings/{id}/schedule', [GreetingController::class, 'showScheduledTime'])->name('greetings.scheduled-time');
    Route::post('/greetings/{id}/send', [GreetingController::class, 'sendMessage'])->name('greetings.send');
    Route::get('/greetings/{id}/edit', [GreetingController::class, 'edit'])->name('greetings.edit');
});

