<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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
// home page
Route::get('/', [ListingController::class,'index']);

//create listing
Route::get('/listing/create', [ListingController::class, 'create'])->middleware('auth');

//store listing
Route::post('/listing', [ListingController::class, 'store'])->middleware('auth');


//delete listing
Route::delete('/listing/{listing}', [ListingController::class, 'delete'])->middleware('auth');

//manage listing
Route::get('/listing/manage', [ListingController::class, 'manage'])->middleware('auth');


// show edit listing
Route::get('/listing/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');


//update listing
Route::put('/listing/{listing}', [ListingController::class, 'update'])->middleware('auth');

// get single listings
Route::get('/listing/{listing}', [ListingController::class,'show']);



//USERS ROUTE

//show user register form 
Route::get('/register', [UserController::class, 'create'])->middleware('guest');


//store registered users
Route::post('/users', [UserController::class, 'store']);

//Logout user
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth')->middleware('guest');


//get login form
Route::get('/login', [UserController::class, 'login'])->name('login');

Route::post('/users/auth', [UserController::class, 'authenticate']);