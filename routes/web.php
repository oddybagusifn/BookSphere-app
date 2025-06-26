<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\HomepageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BorrowingController;

Route::get('/', function () {
    return view('landingPage');
})->name('landing-page');


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login-store');

Route::get('/register', [RegisterController::class, 'index'])->name('register-page');
Route::post('/register', [RegisterController::class, 'store'])->name('register-store');


Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('landing-page');
})->name('logout');


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('admin/books', [AdminController::class, 'books'])->name('admin.books');
    Route::get('/books/create', [AdminController::class, 'create'])->name('admin.books.create');
    Route::post('/books', [AdminController::class, 'store'])->name('admin.books.store');
    Route::get('/books/{book}', [AdminController::class, 'show'])->name('admin.books.show');
    Route::get('/books/{book}/edit', [AdminController::class, 'edit'])->name('admin.books.edit');
    Route::put('/books/{book}', [AdminController::class, 'update'])->name('admin.books.update');
    Route::delete('/books/{book}', [AdminController::class, 'destroy'])->name('admin.books.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    Route::get('/admin/borrowings', [BorrowingController::class, 'index'])->name('admin.borrowings.index');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/homepage', [HomepageController::class, 'index'])->name('homepage');
});
