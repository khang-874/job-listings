<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\List_;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
use Illuminate\Routing\Router;

Route::get('/', [ListingController::class, 'index']);
Route::get('/listings/create', [ListingController::class, 'create']) -> middleware('auth');

//Store listing data
Route::post('/listings', [ListingController::class, 'store']) -> middleware('auth');

//Edit listing
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit']) -> middleware('auth');

//update listing
Route::put('/listings/{listing}', [ListingController::class, 'update']) -> middleware('auth');

//delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy']) -> middleware('auth');

//Manage Listings
Route::get('/listings/manage', [ListingController::class, 'manage']) -> middleware('auth');

//Put this at the bottom
//single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);



//Show register /create form
Route::get('/register', [UserController::class, 'create']) -> middleware('guest');

//Create new user
Route::post('/users', [UserController::class, 'store']) -> middleware('guest');

//Log user out
Route::post('/logout', [UserController::class, 'logout']) -> middleware('auth');

//Show login form
Route::get('/login', [UserController::class, 'login']) -> name('login') -> middleware('guest');

//Log user in
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
// All listings
// Route::get('/', function () {
//     return view('listings',[
//         // 'heading' => 'Lastest Listings',
//         'listings' => Listing::all()
//     ]);
// });

// // Single listing
// Route::get('/listings/{listing}', function(Listing $listing){

//     return view('listing', [
//         'listing' => $listing
//     ]);
//     // $listing = Listing::find($id);
//     // if($listing){
//     //     return view('listing', [
//     //         'listing' => $listing
//     //     ]);
//     // }else{
//     //     abort('404');
//     // }
// });
// Route::get('/hello', function(){
//     return response('<h1>Hello World</h1>')
//     ->header('Content-Type', 'text/plain');
// });

// Route::get('/posts/{id}', function($id){
//     ddd($id);
//     return response('Post ' . $id);
// })-> where('id', '[0-9]+');

// Route::get('/search', function(Request $request){
//     return($request -> name . ' ' . $request -> city);
// });