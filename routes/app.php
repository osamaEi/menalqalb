<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;
use App\Http\Controllers\AppCardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GreetingController;
use App\Http\Controllers\LoginAppController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\AppLockersController;
use App\Http\Controllers\MessageAppController;
use App\Http\Controllers\ProfileAppController;
use App\Http\Controllers\RegisterAppController;
use App\Http\Controllers\PackagePurchaseController;

/*
|--------------------------------------------------------------------------
| App Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::prefix('app')->name('app.')->group(function () {
    // Registration flow
    Route::get('/register', [RegisterAppController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterAppController::class, 'submitRegistrationForm']);

    Route::get('/register/phone', [RegisterAppController::class, 'showPhoneForm'])->name('register.phone');
    Route::post('/register/phone', [RegisterAppController::class, 'submitPhoneForm']);

    Route::get('/register/otp', [RegisterAppController::class, 'showOtpForm'])->name('register.otp');
    Route::post('/register/otp', [RegisterAppController::class, 'verifyOtp']);
    Route::post('/verifyForgotPasswordOtp/otp', [RegisterAppController::class, 'verifyForgotPasswordOtp']);
    Route::post('/register/otp/resend', [RegisterAppController::class, 'resendOtp'])->name('register.otp.resend');

    Route::get('/register/password', [RegisterAppController::class, 'showPasswordForm'])->name('register.password');
    Route::post('/register/password', [RegisterAppController::class, 'completeRegistration']);
    Route::get('/register/complete', [RegisterAppController::class, 'showCompletePage'])->name('register.complete');
});


Route::middleware('guest')->prefix('app')->name('app.')->group(function () {
    
    // Login routes
    Route::get('/login', [LoginAppController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginAppController::class, 'login']);

    
    
    // Forgot password routes
    Route::get('/forgot-password', [LoginAppController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('/forgot-password', [LoginAppController::class, 'forgotPassword'])->name('forgot-password.post');
    Route::get('forgot-password/otp', [LoginAppController::class, 'showOtpForm'])->name('forgot-password.otp');
    Route::post('forgot-password/verify', [LoginAppController::class, 'verifyOtp'])->name('forgot-password.verify');
    Route::get('forgot-password/reset', [LoginAppController::class, 'showResetPasswordForm'])->name('forgot-password.reset');
    Route::post('forgot-password/reset', [LoginAppController::class, 'resetPassword'])->name('forgot-password.reset.store');
    Route::post('forgot-password/resend', [LoginAppController::class, 'resendOtp'])->name('forgot-password.resend');


});


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
    Route::post('/logout', [LoginAppController::class, 'logout'])->name('logout');

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

Route::middleware(['auth'])->group(function () {
    // Display available packages
    Route::get('/packages', [PackagePurchaseController::class, 'index'])
         ->name('packages.index');
    
    // Handle package purchase request
    Route::post('/packages/purchase/{id}', [PackagePurchaseController::class, 'purchase'])
         ->name('packages.purchase');
    

         Route::get('/packages/payment/success', [PackagePurchaseController::class, 'handleSuccess'])
         ->name('packages.payment.success');
    // Payment cancel callback
    Route::get('/packages/payment/cancel', [PackagePurchaseController::class, 'handleCancel'])
         ->name('packages.payment.cancel');
});
// Ziina webhook route
// Route::post('/webhooks/ziina', [ZiinaPaymentController::class, 'handleWebhook'])
//     ->name('ziina.webhook');


Route::middleware(['auth'])->prefix('min-alqalb')->name('min-alqalb.')->group(function () {
        Route::get('/lockers', [AppLockersController::class, 'index'])->name('lockers.index');
        Route::get('/lockers/create', [AppLockersController::class, 'createRequest'])->name('lockers.create');
        Route::post('/lockers/store', [AppLockersController::class, 'storeRequest'])->name('lockers.store');
        Route::get('/lockers/summary', [AppLockersController::class, 'showSummary'])->name('lockers.summary');
        Route::post('/lockers/purchase', [AppLockersController::class, 'purchase'])->name('lockers.purchase');
        Route::get('/lockers/payment/success', [AppLockersController::class, 'handleSuccess'])->name('lockers.payment.success');
        Route::get('/lockers/payment/cancel', [AppLockersController::class, 'handleCancel'])->name('lockers.payment.cancel');
        Route::get('/lockers/finish', function () {
            return view('app.lockers.finish');
        })->name('lockers.finish');
    });

    Route::middleware(['auth'])->prefix('min-alqalb')->name('min-alqalb.')->group(function () {
        Route::get('/cards', [AppCardController::class, 'index'])->name('cards.index');
        Route::get('/cards/create', [AppCardController::class, 'createRequest'])->name('cards.create');
        Route::post('/cards/store', [AppCardController::class, 'storeRequest'])->name('cards.store');
        Route::get('/cards/summary', [AppCardController::class, 'showSummary'])->name('cards.summary');
        Route::post('/cards/purchase', [AppCardController::class, 'purchase'])->name('cards.purchase');
        Route::get('/cards/payment/success', [AppCardController::class, 'handleSuccess'])->name('cards.payment.success');
        Route::get('/cards/payment/cancel', [AppCardController::class, 'handleCancel'])->name('cards.payment.cancel');
        Route::get('/cards/finish', function () {
            return view('app.cards.finish');
        })->name('cards.finish');
    });


Route::middleware('auth')->prefix('app')->name('app.')->group(function () {
    Route::get('/bills', [BillController::class, 'index'])->name('bills.index');
    Route::get('/bills/{bill}', [BillController::class, 'show'])->name('bills.show');
    Route::get('/bills/{bill}/pdf', [BillController::class, 'generatePdf'])->name('bills.pdf');
});

Route::prefix('app')->name('app.')->group(function () {
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
});


Route::get('/verify-email/{token}', [RegisterAppController::class, 'verifyEmail'])->name('verify.email');
