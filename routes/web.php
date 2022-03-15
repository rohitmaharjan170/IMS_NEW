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
// Route::get('auth/login', 'LoginController@authenticated');

Route::get('/', 'PagesController@index'); //ControllerName and @methodWeWant

Route::get('/about', 'PagesController@about'); //>>ROUTE TO ABOUT PAGE<<


// Route::get('/services', 'PagesController@services'); //>>ROUTE TO SERVICES PAGE<<

Route::get('products/{id}/stock', 'ProductsController@stock');
Route::put('products/{id}/addStock', 'ProductsController@addStock');
Route::resource('products', 'ProductsController');
Auth::routes();

Route::get('/dashboard', 'DashboardController@sales');
Route::get('/dashboard', 'DashboardController@index');
// Route::get('/hello', 'DashboardController');
Route::resource('clients', 'ClientsController');

Route::get('client_order/{client_name}', 'OrdersController@clientOrder');
Route::get('product_order/{product_name}', 'OrdersController@productOrder');
Route::get('orders/due', 'OrdersController@due');
Route::get('bill_order/{bill_id}', 'OrdersController@billOrder');
Route::get('order_date/{order_date}', 'OrdersController@orderDate');
Route::get('pay_date/{payment_date}', 'OrdersController@payDate');
Route::get('export', 'OrdersController@export');
// Route::get('export_orders', 'OrdersController@exportDatedOrders');



Route::get('orders/{id}/payment', 'OrdersController@payment');
Route::put('orders/{id}/addPayment', 'OrdersController@addPayment');

Route::get('orders/pay_up', 'OrdersController@payUp');
// Route::get('orders/info', 'OrdersController');

Route::resource('orders', 'OrdersController');

Route::post('/fetch', 'OrdersController@fetch')->name('orderscontroller.fetch');

Route::post('/findRate', 'OrdersController@findRate');
Route::post('/findQuantity', 'OrdersController@findQuantity');

Route::resource('stock_logs', 'StockLogsController');

Route::get('purchase_bill/{pbill_id}', 'PurchasesController@purchaseBill');
Route::get('purchase_date/{purchase_date}', 'PurchasesController@purchaseDate');
Route::get('supplier_report/{supplier}', 'PurchasesController@supplierReport');
Route::get('purchases/due', 'PurchasesController@due');
Route::get('purchases/pay_up', 'PurchasesController@payUp');
Route::get('pay_date/{payment_date}', 'PurchasesController@payDate');

Route::get('purchases/{id}/payment', 'PurchasesController@payment');
Route::put('purchases/{id}/addPayment', 'PurchasesController@addPayment');



Route::resource('purchases', 'PurchasesController');

Route::get('logs', 'LogsController@index');

//dashboard
Route::get('create', 'DashboardController@create');
Route::post('/store', 'DashboardController@store');

Route::get('{id}/edit_vendor', 'DashboardController@edit');
// Route::post('update', 'DashboardController@update');
Route::match(['put', 'patch'], '/{id}/edit_vendor','DashboardController@update');


Route::get('setting', 'DashboardController@setting');

// Route::post('{id}/setting', 'DashboardController@destroy');
Route::delete('/setting/{id}', 'DashboardController@destroy')->name('setting.destroy');
// Route::resource('setting', 'DashboardController');

Route::get('/staff', 'DashboardController@staff');
Route::delete('/user/{id}', 'DashboardController@del');
Route::get('/{id}/user', 'DashboardController@show_user');
Route::get('{id}/edit_user', 'DashboardController@edit_user');
Route::match(['put', 'patch'], '/{id}/edit_user','DashboardController@update_user');

// Route::get('/', 'DashboardController@span');
// Route::get('/', function(){
// 	return view('admin.index');
// })->name('admin.index');


// Route::get('orders/bill_order/{id}', function(){
// 	return view('orders/bill_order/{id}');
// });

// Route::post('fetch', 'orderController@fetch')->name('dynamicdependent.fetch');
// Route::get('clients', 'OrdersController@create');
// Route::get('products', 'OrdersController@create');

// Route::get('/findRate','OrdersController@findRate');



// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

// Route::group(['middleware' => 'auth'], function () {
// 	Route::get('table-list', function () {
// 		return view('pages.table_list');
// 	})->name('table');

// 	Route::get('typography', function () {
// 		return view('pages.typography');
// 	})->name('typography');

// 	Route::get('icons', function () {
// 		return view('pages.icons');
// 	})->name('icons');

// 	Route::get('map', function () {
// 		return view('pages.map');
// 	})->name('map');

// 	Route::get('notifications', function () {
// 		return view('pages.notifications');
// 	})->name('notifications');

// 	Route::get('rtl-support', function () {
// 		return view('pages.language');
// 	})->name('language');

// 	Route::get('upgrade', function () {
// 		return view('pages.upgrade');
// 	})->name('upgrade');
// });

// Route::get('/staffs/create', 'UserController@create');
// Route::post('/staffs/store', 'UserController@store');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

// Route::get('user/{site}/delete', ['as' => 'user.delete', 'uses' => 'UserController@destroy']);