<?php
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Services\Route;

Route::get('', 'HomeController', 'index');

//Art 
Route::get('art-gallery', 'ArtController', 'index');
Route::get('viewart/{a}', 'ArtController', 'view');
//Artists
Route::get('artists', 'ArtistsController', 'index');
Route::get('api/artists', 'ArtistsController', 'getArtists');

//auth routes
Route::get('login', 'AuthController', 'loginView');
Route::post('login', 'AuthController', 'login');
Route::get('signup', 'AuthController', 'signupView');
Route::post('signup', 'AuthController', 'singup');
Route::get('add-artists', 'AuthController', 'artistView');
Route::post('store-artists', 'AuthController', 'artists');
//default page
Route::get('terms', 'DashboardController', 'terms');
Route::get('privacy', 'DashboardController', 'privacy');
Route::get('contact', 'DashboardController', 'contact');
Route::get('about', 'DashboardController', 'about');
Route::get('cookie', 'DashboardController', 'cookie');
Route::get('404', 'DashboardController', 'notFound');
Route::get('503', 'DashboardController', 'accessDeined');
Route::post('logout', 'DashboardController', 'logout', [AuthMiddleware::class]);
