<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MySchoolController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Publishers
        Route::resource('publishers', PublisherController::class);

        // Books
        Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
        Route::resource('books', BookController::class);

        // Schools
        Route::resource('schools', SchoolController::class);
        Route::prefix('schools/{school}')->group(function () {
            Route::get('/withdraw', [WithdrawController::class, 'create'])->name('withdraw.create');
            Route::post('/withdraw', [WithdrawController::class, 'store'])->name('withdraw.store');
        });

        // Bundles
        Route::resource('bundles', BundleController::class);
        Route::get('/bundles/print/{bundle}', [BundleController::class, 'print'])->name('bundles.print');

        // Sales
        Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
        Route::get('/sales/print/{invoice}', [SaleController::class, 'print'])->name('sales.print');

        // Checkouts
        Route::get('/checkout/bundle/{bundle}', [CheckoutController::class, 'show'])->name('checkout.bundle.show');
        Route::post('/checkout/bundle/{bundle}', [CheckoutController::class, 'process'])->name('checkout.bundle.process');
        Route::get('/checkout/verify', [CheckoutController::class, 'verifyPayment'])->name('checkout.bundle.verify');
    });

    Route::middleware('role:school_head')->group(function () {
        Route::get('/my-school', [SchoolController::class, 'mySchool'])->name('schools.myschool');
    });

    // Profiles
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
