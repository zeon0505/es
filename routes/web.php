<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\PosterController;

// ═══════════════════════════════════════════
//  PUBLIC ROUTES
// ═══════════════════════════════════════════
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/visi-misi',  [PageController::class, 'visiMisi'])->name('pages.visi-misi');
Route::get('/dosen',      [PageController::class, 'dosen'])->name('pages.dosen');
Route::get('/dosen/{dosen:nidn}', [PageController::class, 'dosenShow'])->name('pages.dosen.show');
Route::get('/kurikulum',  [PageController::class, 'kurikulum'])->name('pages.kurikulum');
Route::get('/berita',     [PageController::class, 'berita'])->name('pages.berita');
Route::get('/berita/{slug}', [PageController::class, 'beritaShow'])->name('pages.berita.show');
Route::get('/akreditasi', [PageController::class, 'akreditasi'])->name('pages.akreditasi');

// ═══════════════════════════════════════════
//  ADMIN ROUTES (tersembunyi dari publik)
// ═══════════════════════════════════════════
Route::prefix('admin')->name('admin.')->group(function () {
    // Login (tanpa auth)
    Route::get('/login',  [AdminController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');

    // Route terproteksi
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::resource('slides',   SlideController::class)->except(['show']);
        Route::resource('dosens',   DosenController::class)->except(['show']);
        Route::resource('kategoris', KategoriController::class)->except(['show']);
        Route::resource('beritas',  BeritaController::class)->except(['show']);
        Route::post('/beritas/scrape',      [BeritaController::class, 'scrapeUrl'])->name('beritas.scrape');
        Route::post('/beritas/store-bulk',  [BeritaController::class, 'storeBulk'])->name('beritas.store-bulk');
        Route::resource('posters',  PosterController::class)->except(['show']);
    });
});