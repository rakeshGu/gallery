<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GalleryController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//For showing an image
Route::get('/',[GalleryController::class,'viewImage'])->name('images.view'); 

//For adding an image
Route::get('/add-image',[GalleryController::class,'addImage'])->name('images.add');

//For storing an image
Route::post('/store-image',[GalleryController::class,'storeImage'])->name('images.store');

//For map view
Route::get('/map-view/{id}',[GalleryController::class,'mapView'])->name('images.map');
