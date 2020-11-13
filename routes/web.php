<?php

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

// front route start
Route::get('/', 'FrontController@welcome')->name('front');

Route::get('/contact-us', 'FrontController@contactUs')->name('front.contact-us');
Route::post('/contact-submit', 'FrontController@contactSubmit')->name('front.contact-submit');

Route::get('/product/{category_id?}', 'FrontController@product')->name('front.product');
Route::get('/detail/{product_id}', 'FrontController@detail')->name('front.detail');
Route::get('/update-detail/{product_id}', 'FrontController@updateDetail')->name('front.update-detail');
Route::get('/order/list', 'FrontController@orderList')->name('front.order-list');
Route::get('/order/detail/{order_id?}', 'FrontController@orderDetail')->name('front.order-detail');
Route::get('/order/cancel/{order_id?}', 'FrontController@orderCancel')->name('front.order-cancel');

Route::get('/cart', 'FrontController@cart')->name('front.cart');
Route::post('/cart/add', 'FrontController@cartAdd')->name('front.cart.add');
Route::post('/cart/incr', 'FrontController@cartIncr')->name('front.cart.incr');
Route::post('/cart/decr', 'FrontController@cartDecr')->name('front.cart.decr');
Route::post('/cart/remove', 'FrontController@cartRemove')->name('front.cart.remove');

// auth route start
Route::get('/login', 'FrontController@login')->name('front.login');
Route::post('/login/submit', 'FrontController@loginSubmit')->name('front.login-submit');

Route::get('/register', 'FrontController@register')->name('front.register');
Route::post('/register/submit', 'FrontController@registerSubmit')->name('front.register-submit');

Route::get('/logout', 'FrontController@logout')->name('front.logout');
// auth route end

Route::get('/order', 'FrontController@order')->name('front.order');
Route::post('/order/submit', 'FrontController@orderSubmit')->name('front.order-submit');
// front route end

Route::group(['prefix' => 'admin'], function() {
    Auth::routes();
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    // category route start
    Route::resource('category', 'CategoryController');
    Route::post('category/status/{id?}', 'CategoryController@status')->name('category.status');
    Route::post('category/toggle-status/{id?}/{status?}', ['as' => 'category.toggle-status', 'uses' => 'CategoryController@toggleStatus']);
    Route::post('category/toggle-all-status/{status?}', ['as' => 'category.toggle-all-status', 'uses' => 'CategoryController@toggleAllStatus']);
    // category route end

    // product route start
    Route::resource('product', 'ProductController');
    Route::post('product/status/{id?}', 'ProductController@status')->name('product.status');
    Route::post('product/toggle-status/{id?}/{status?}', ['as' => 'product.toggle-status', 'uses' => 'ProductController@toggleStatus']);
    Route::post('product/toggle-all-status/{status?}', ['as' => 'product.toggle-all-status', 'uses' => 'ProductController@toggleAllStatus']);
    Route::get('product/delete-img/{product_id?}/{product_img_id?}', ['as' => 'product.delete-img', 'uses' => 'ProductController@deleteImg']);
    // product route end
});
