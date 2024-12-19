<?php
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Services\Route;
// home page
Route::get('', 'HomeController', 'index');
Route::get('api/load-limited-edition-prints', 'ArtController', 'loadLimitedEditionPrints');
Route::get('api/focus-artists', 'ArtistsController', 'focusArtists');

//Art gallery page
Route::get('art-gallery', 'ArtController', 'index');

//view art page
Route::get('viewart/{a}', 'ArtController', 'view');
Route::get('api/more-from-artists', 'ArtController', 'moreFromArtist');

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
