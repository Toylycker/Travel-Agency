<?php

use App\Http\Controllers\admin\ApplicationController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\HotelController;
use App\Http\Controllers\admin\PlaceController;
use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\admin\TourController;
use App\Http\Controllers\admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::put('/tours/{id}/edit/name', [TourController::class, 'putName'])->name('tours.edit.name');
    Route::put('/tours/{id}/edit/body', [TourController::class, 'putBody'])->name('tours.edit.body');
    Route::put('/tours/{id}/edit/map', [TourController::class, 'putMap'])->name('tours.edit.map');
    Route::post('/tours/{id}/edit/main_image', [TourController::class, 'putMainImage'])->name('tours.edit.main_image');
    Route::put('/tours/{id}/edit/total_days', [TourController::class, 'putTotalDays'])->name('tours.edit.total_days');
    Route::put('/tours/{id}/edit/tour_prices', [TourController::class, 'putTourPrices'])->name('tours.edit.tour_prices');
    Route::put('/tours/{id}/edit/viewed', [TourController::class, 'putViewed'])->name('tours.edit.viewed');
    Route::put('/tours/{id}/edit/recommended', [TourController::class, 'putRecommended'])->name('tours.edit.recommended');
    Route::post('/tours/{id}/edit/images', [TourController::class, 'putImages'])->name('tours.edit.images');
    Route::put('/tours/{id}/edit/notes', [TourController::class, 'putNotes'])->name('tours.edit.notes');
    Route::put('/tours/{id}/edit/prices', [TourController::class, 'putPrices'])->name('tours.edit.prices');
    Route::put('/tours/{id}/edit/days', [TourController::class, 'putDays'])->name('tours.edit.days');
    Route::resources([
    'places'=> PlaceController::class,
    'tours'=> TourController::class,
    'posts'=> PostController::class,
    'hotels'=> HotelController::class,
    'users'=> UserController::class]);
    Route::get('/applications/index', [ApplicationController::class, 'index'])->name('applications.index');
});