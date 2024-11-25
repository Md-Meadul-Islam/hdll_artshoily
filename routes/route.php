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

//default page
Route::get('terms', 'DashboardController', 'terms');
Route::get('privacy', 'DashboardController', 'privacy');
Route::get('contact', 'DashboardController', 'contact');
Route::get('about', 'DashboardController', 'about');
Route::get('cookie', 'DashboardController', 'cookie');
Route::get('404', 'DashboardController', 'notFound');
Route::get('503', 'DashboardController', 'accessDeined');
Route::post('logout', 'DashboardController', 'logout', [AuthMiddleware::class]);
