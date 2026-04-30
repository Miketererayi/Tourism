<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/robots.txt', [App\Http\Controllers\RobotsController::class, 'index']);
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index']);
Route::get('/sitemap-{code}.xml', [App\Http\Controllers\SitemapController::class, 'country']);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/place/{slug}', [PlaceController::class, 'show'])->name('place.show');
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send')->middleware('throttle:3,1');
