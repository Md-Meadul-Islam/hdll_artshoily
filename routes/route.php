<?php
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Services\Route;
// home page
Route::get('', 'HomeController', 'index');
Route::get('api/load-limited-edition-prints', 'ArtController', 'loadLimitedEditionPrints');
Route::get('api/focus-artists', 'ArtistsController', 'focusArtists');
Route::get('api/home-sculptures', 'SculptureController', 'homeSculpture');

//Art gallery page
Route::get('art-gallery', 'ArtController', 'index');

//view art page
Route::get('viewart/{a}', 'ArtController', 'view');
Route::get('api/more-from-artists', 'ArtController', 'moreFromArtist');

//Artists
Route::get('artists', 'ArtistsController', 'index');
Route::get('viewartists/{a}', 'ArtistsController', 'view');
Route::get('api/artists', 'ArtistsController', 'getArtists');
Route::get('api/load-arts-of-artist', 'ArtistsController', 'getArtOfArtist');

//auth routes
Route::get('login', 'AuthController', 'loginView');
Route::post('login', 'AuthController', 'login');
Route::get('signup', 'AuthController', 'signupView');
Route::post('signup', 'AuthController', 'signup');

//admin routes
Route::get('admin/dashboard', 'AdminController', 'index', [AuthMiddleware::class]);
Route::get('admin', 'AuthController', 'adminLoginView', [GuestMiddleware::class]);
Route::post('admin', 'AuthController', 'adminLogin', [GuestMiddleware::class]);

#region Arts
Route::get('admin/load-arts-paginate', 'AdminController', 'loadArtsPaginate');
Route::get('admin/create-art-modal', 'AdminController', 'loadCreateArtModal', []);
Route::get('admin/copy-art-modal', 'AdminController', 'loadCopyArtModal', []);
Route::post('store-art', 'ArtController', 'storeArt', [AuthMiddleware::class]);
Route::post('update-art', 'ArtController', 'updateArt', [AuthMiddleware::class]);
Route::post('delete-art', 'ArtController', 'delete', [AuthMiddleware::class]);
#endregion
#region users = artists / blogger
Route::get('admin/load-users-paginate', 'UserController', 'loadUsersPaginate');
Route::get('admin/add-user-modal', 'UserController', 'loadCreateUserModal', [AuthMiddleware::class]);
Route::post('admin/store-user', 'UserController', 'store', [AuthMiddleware::class]);
Route::get('admin/edit-user-modal', 'UserController', 'loadEditUserModal', [AuthMiddleware::class]);
Route::post('admin/update-user', 'UserController', 'update', [AuthMiddleware::class]);
Route::post('admin/delete-user', 'UserController', 'delete', [AuthMiddleware::class]);
#endregion
#region Blogs
Route::get('blogs', 'BlogController', 'index');
Route::get('blog/{b}', 'BlogController', 'blog');
Route::get('load-blogs-paginate', 'BlogController', 'loadBlogPaginate');
Route::get('create-blog-modal', 'BlogController', 'loadCreateBlogModal');
Route::post('store-blog', 'BlogController', 'storeBlog');
Route::get('edit-blog-modal', 'BlogController', 'loadEditBlogModal');
Route::post('update-blog', 'BlogController', 'updateBlog');
Route::post('delete-blog', 'BlogController', 'deleteBlog');
#endregion
#region Sculptures
Route::get('view-sculpture/{a}', 'SculptureController', 'view');
Route::get('sculptures', 'SculptureController', 'index');
Route::get('admin/load-sculptures-paginate', 'SculptureController', 'loadSculpPaginate');
Route::get('admin/create-sculpture-modal', 'SculptureController', 'loadCreateSculpModal');
Route::get('admin/copy-sculp-modal', 'SculptureController', 'loadCopySculpModal');
Route::post('store-sculpture', 'SculptureController', 'store');
Route::get('admin/edit-sculpture-modal', 'SculptureController', 'loadEditSculpModal');
Route::post('update-sculpture', 'SculptureController', 'update');
Route::post('delete-sculpture', 'SculptureController', 'delete');
#endregion
#region Focus Artists
Route::get('admin/load-focus-artists-paginate', 'ArtistsController', 'paginatedFocusArtists', [AuthMiddleware::class]);
Route::get('admin/add-focus-artists-modal', 'UserController', 'loadFocusArtistsModal', [AuthMiddleware::class]);
Route::post('store-focus-artists', 'ArtistsController', 'storeFocusArtists', [AuthMiddleware::class]);
Route::post('delete-focus-artists', 'ArtistsController', 'deleteFocusArtists', [AuthMiddleware::class]);
#endregion
#region Default page
Route::get('terms', 'HomeController', 'terms');
Route::get('privacy', 'HomeController', 'privacy');
Route::get('contact', 'HomeController', 'contact');
Route::get('about', 'HomeController', 'about');
Route::get('cookie', 'HomeController', 'cookie');
Route::get('404', 'HomeController', 'notFound');
Route::get('503', 'HomeController', 'accessDeined');
Route::post('logout', 'HomeController', 'logout', [AuthMiddleware::class]);
#endregion
