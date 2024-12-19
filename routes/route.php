<?php
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Services\Route;

Route::get('', 'HomeController', 'index');

//Art 
Route::get('art-gallery', 'ArtController', 'index');
Route::get('viewart/{a}', 'ArtController', 'view');
Route::get('api/more-from-artists', 'ArtController', 'moreFromArtist');
Route::get('load-limited-edition-prints', 'ArtController', 'loadLimitedEditionPrints');
//Artists
Route::get('artists', 'ArtistsController', 'index');
Route::get('api/artists', 'ArtistsController', 'getArtists');

//auth routes
Route::get('login', 'AuthController', 'loginView');
Route::post('login', 'AuthController', 'login');
Route::get('signup', 'AuthController', 'signupView');
Route::post('signup', 'AuthController', 'signup');
Route::get('admin/add-artists', 'AuthController', 'artistView');
Route::post('admin/store-artists', 'AuthController', 'artists');

//admin routes
Route::get('admin', 'AdminController', 'index', []);
Route::get('admin/load-arts-paginate', 'AdminController', 'loadArtsPaginate');
Route::get('admin/create-art-modal', 'AdminController', 'loadCreateArtModal', []);

//default page
Route::get('terms', 'HomeController', 'terms');
Route::get('privacy', 'HomeController', 'privacy');
Route::get('contact', 'HomeController', 'contact');
Route::get('about', 'HomeController', 'about');
Route::get('cookie', 'HomeController', 'cookie');
Route::get('404', 'HomeController', 'notFound');
Route::get('503', 'HomeController', 'accessDeined');
Route::post('logout', 'HomeController', 'logout', [AuthMiddleware::class]);
