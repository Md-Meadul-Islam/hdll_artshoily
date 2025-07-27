<?php
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Services\Route;
// home page
Route::get('', 'HomeController', 'index');
Route::get('api/load-limited-edition-prints', 'ArtController', 'loadLimitedEditionPrints');
Route::get('api/focus-artists', 'ArtistsController', 'focusArtists');
Route::get('api/home-sculptures', 'SculptureController', 'homeSculpture');

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
Route::get('admin/dashboard', 'AdminController', 'index', [[AuthMiddleware::class, 'admin']]);
Route::get('admin', 'AuthController', 'adminLoginView', [GuestMiddleware::class]);
Route::post('admin', 'AuthController', 'adminLogin', [GuestMiddleware::class]);

#region Arts
Route::get('admin/load-arts-paginate', 'AdminController', 'loadArtsPaginate');
Route::get('admin/create-art-modal', 'AdminController', 'loadCreateArtModal', []);
Route::get('admin/copy-art-modal', 'AdminController', 'loadCopyArtModal', []);
Route::post('store-art', 'ArtController', 'storeArt', [[AuthMiddleware::class, 'admin']]);
Route::post('update-art', 'ArtController', 'updateArt', [[AuthMiddleware::class, 'admin']]);
Route::post('delete-art', 'ArtController', 'delete', [[AuthMiddleware::class, 'admin']]);
#endregion
#region Art gallery page
Route::get('art-gallery', 'ArtController', 'index');
Route::get('load-art-paginate', 'ArtController', 'paginatedArts');
#endregion
#region users = artists / blogger
Route::get('admin/load-users-paginate', 'UserController', 'loadUsersPaginate');
Route::get('admin/add-user-modal', 'UserController', 'loadCreateUserModal', [[AuthMiddleware::class, 'admin']]);
Route::post('admin/store-user', 'UserController', 'store', [[AuthMiddleware::class, 'admin']]);
Route::get('admin/edit-user-modal', 'UserController', 'loadEditUserModal', [[AuthMiddleware::class, 'admin']]);
Route::post('admin/update-user', 'UserController', 'update', [[AuthMiddleware::class, 'admin']]);
Route::post('admin/delete-user', 'UserController', 'delete', [[AuthMiddleware::class, 'admin']]);
Route::post('admin/change-user-status', 'UserController', 'changeStatus', [[AuthMiddleware::class, 'admin']]);

Route::post('admin/update-row-order', 'AdminController', 'updateRowOrder', [[AuthMiddleware::class, 'admin']]);

#endregion
#region Blogs
Route::get('blogs', 'BlogController', 'index');
Route::get('blog/{b}', 'BlogController', 'blog');
Route::get('load-blogs-paginate', 'BlogController', 'loadBlogPaginate');
Route::get('create-blog-modal', 'BlogController', 'loadCreateBlogModal',[[AuthMiddleware::class, 'admin']]);
Route::post('store-blog', 'BlogController', 'storeBlog', [[AuthMiddleware::class, 'admin']]);
Route::get('edit-blog-modal', 'BlogController', 'loadEditBlogModal', [[AuthMiddleware::class, 'admin']]);
Route::post('update-blog', 'BlogController', 'updateBlog', [[AuthMiddleware::class, 'admin']]);
Route::post('delete-blog', 'BlogController', 'deleteBlog', [[AuthMiddleware::class, 'admin']]);
#endregion
#region Sculptures
Route::get('view-sculpture/{a}', 'SculptureController', 'view');
Route::get('sculptures', 'SculptureController', 'index');
Route::get('admin/load-sculptures-paginate', 'SculptureController', 'loadSculpPaginate');
Route::get('admin/create-sculpture-modal', 'SculptureController', 'loadCreateSculpModal', [[AuthMiddleware::class, 'admin']]);
Route::get('admin/copy-sculp-modal', 'SculptureController', 'loadCopySculpModal', [[AuthMiddleware::class, 'admin']]);
Route::post('store-sculpture', 'SculptureController', 'store', [[AuthMiddleware::class, 'admin']]);
Route::get('admin/edit-sculpture-modal', 'SculptureController', 'loadEditSculpModal', [[AuthMiddleware::class, 'admin']]);
Route::post('update-sculpture', 'SculptureController', 'update',[[AuthMiddleware::class, 'admin']]);
Route::post('delete-sculpture', 'SculptureController', 'delete',[[AuthMiddleware::class, 'admin']]);
#endregion
#region Focus Artists
Route::get('admin/load-focus-artists-paginate', 'ArtistsController', 'paginatedFocusArtists', [[AuthMiddleware::class, 'admin']]);
Route::get('admin/add-focus-artists-modal', 'UserController', 'loadFocusArtistsModal', [[AuthMiddleware::class, 'admin']]);
Route::post('store-focus-artists', 'ArtistsController', 'storeFocusArtists', [[AuthMiddleware::class, 'admin']]);
Route::post('delete-focus-artists', 'ArtistsController', 'deleteFocusArtists', [[AuthMiddleware::class, 'admin']]);
#endregion
#region blogger
Route::get('blogger', 'BloggerController', 'index', [[AuthMiddleware::class, 'blogger']]);
Route::get('blogger/load-blogs-paginate', 'BloggerController', 'loadBlogsPaginate', [[AuthMiddleware::class, 'blogger']]);
Route::get('blogger/create-blog-modal', 'BloggerController', 'loadCreateBlogModal', [[AuthMiddleware::class, 'blogger']]);
Route::get('blogger/edit-blog-modal', 'BloggerController', 'loadEditBlogModal', [[AuthMiddleware::class, 'blogger']]);
Route::post('blogger/store-blog', 'BloggerController', 'storeBlog',[[AuthMiddleware::class, 'blogger']]);
Route::post('blogger/update-blog', 'BloggerController', 'updateBlog',[[AuthMiddleware::class, 'blogger']]);
Route::post('blogger/delete-blog', 'BloggerController', 'deleteBlog',[[AuthMiddleware::class, 'blogger']]);
#endregion
#region Default page
Route::post('upload-file', 'HomeController', 'uploadFile');
Route::post('delete-file', 'HomeController', 'deleteFile');
Route::get('terms', 'HomeController', 'terms');
Route::get('privacy', 'HomeController', 'privacy');
Route::get('contact', 'HomeController', 'contact');
Route::get('about', 'HomeController', 'about');
Route::get('cookie', 'HomeController', 'cookie');
Route::get('404', 'HomeController', 'notFound');
Route::get('503', 'HomeController', 'accessDeined');
Route::post('logout', 'HomeController', 'logout', [AuthMiddleware::class]);
#endregion
