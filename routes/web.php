<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PhotographerController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;


// Public
Route::get('/', fn() => view('welcome'));
Route::get('/photographers',      [ClientController::class, 'browsePhotographers'])->name('photographers.index');
Route::get('/photographers/{id}', [ClientController::class, 'showPhotographer'])->name('photographers.show');

// Auth
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// Client
Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard',                      [ClientController::class,  'dashboard'])->name('dashboard');
    Route::get('/bookings',                       [ClientController::class,  'myBookings'])->name('bookings');
    Route::get('/bookings/create',                [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings',                      [BookingController::class, 'store'])->name('bookings.store');
    Route::patch('/bookings/{booking}/cancel',    [BookingController::class, 'clientCancel'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/review',     [ReviewController::class,  'store'])->name('bookings.review');
    Route::get('/payments', [\App\Http\Controllers\PaymentController::class, 'clientPayments'])
     ->name('payments.index');
    });

// Photographer
Route::middleware(['auth', 'role:photographer'])->prefix('photographer')->name('photographer.')->group(function () {
    Route::get('/dashboard',                          [PhotographerController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile/edit',                       [PhotographerController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile',                            [PhotographerController::class, 'updateProfile'])->name('profile.update');

    Route::get('/portfolio',                          [PortfolioController::class, 'index'])->name('portfolio.index');
    Route::post('/portfolio',                         [PortfolioController::class, 'store'])->name('portfolio.store');
    Route::put('/portfolio',                          [PortfolioController::class, 'update'])->name('portfolio.update');
    Route::post('/portfolio/images',                  [PortfolioController::class, 'uploadImages'])->name('portfolio.images.upload');
    Route::delete('/portfolio/images/{image}',        [PortfolioController::class, 'deleteImage'])->name('portfolio.images.delete');

    Route::get('/packages',                           [PackageController::class, 'index'])->name('packages.index');
    Route::get('/packages/create',                    [PackageController::class, 'create'])->name('packages.create');
    Route::post('/packages',                          [PackageController::class, 'store'])->name('packages.store');
    Route::get('/packages/{package}/edit',            [PackageController::class, 'edit'])->name('packages.edit');
    Route::put('/packages/{package}',                 [PackageController::class, 'update'])->name('packages.update');
    Route::patch('/packages/{package}/toggle',        [PackageController::class, 'toggle'])->name('packages.toggle');
    Route::delete('/packages/{package}',              [PackageController::class, 'destroy'])->name('packages.destroy');

    Route::patch('/bookings/{booking}/accept',        [BookingController::class, 'accept'])->name('bookings.accept');
    Route::patch('/bookings/{booking}/cancel',        [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::patch('/bookings/{booking}/complete',      [BookingController::class, 'complete'])->name('bookings.complete');
    Route::get('/payments', [\App\Http\Controllers\PaymentController::class, 'photographerPayments'])
     ->name('payments.index');
});

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',             [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users',                 [AdminController::class, 'users'])->name('users.index');
    Route::patch('/users/{user}/toggle', [AdminController::class, 'toggleUser'])->name('users.toggle');
    Route::delete('/users/{user}',       [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/bookings',              [AdminController::class, 'bookings'])->name('bookings.index');
    Route::get('/photographers',         [AdminController::class, 'photographers'])->name('photographers.index');

    // Package Templates
Route::get('/packages',                      [\App\Http\Controllers\AdminPackageController::class, 'index'])->name('packages.index');
Route::get('/packages/create',               [\App\Http\Controllers\AdminPackageController::class, 'create'])->name('packages.create');
Route::post('/packages',                     [\App\Http\Controllers\AdminPackageController::class, 'store'])->name('packages.store');
Route::get('/packages/{template}/edit',      [\App\Http\Controllers\AdminPackageController::class, 'edit'])->name('packages.edit');
Route::put('/packages/{template}',           [\App\Http\Controllers\AdminPackageController::class, 'update'])->name('packages.update');
Route::patch('/packages/{template}/toggle',  [\App\Http\Controllers\AdminPackageController::class, 'toggle'])->name('packages.toggle');
Route::delete('/packages/{template}',        [\App\Http\Controllers\AdminPackageController::class, 'destroy'])->name('packages.destroy');

// Payments
Route::get('/payments',                          [\App\Http\Controllers\PaymentController::class, 'index'])->name('payments.index');
Route::get('/payments/{payment}',                [\App\Http\Controllers\PaymentController::class, 'show'])->name('payments.show');
Route::patch('/payments/{payment}/mark-paid',    [\App\Http\Controllers\PaymentController::class, 'markPaid'])->name('payments.mark-paid');
Route::patch('/payments/{payment}/mark-pending', [\App\Http\Controllers\PaymentController::class, 'markPending'])->name('payments.mark-pending');


// Client payments
//Route::get('/payments', [\App\Http\Controllers\PaymentController::class, 'clientPayments'])->name('payments.index');

// Photographer payments
//
// Route::get('/payments', [\App\Http\Controllers\PaymentController::class, 'photographerPayments'])->name('payments.index');
});

