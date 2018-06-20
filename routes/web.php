<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/admin/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login','Auth\AdminLoginController@login')->name('admin.login.submit');
Route::get('/admin', 'AdminController@index')->name('admin.home');


///admin routes-----------------------------------

Route::group(['middleware' => 'auth:admin'], function () {
    Route::post('/admin/add/company/profile','AdminController@editCompanyProfile');
    Route::post('/admin/changeOrderAdvance','OrderController@setAdvance');
    Route::post('/admin/changeOrderValueGbp','OrderController@setOrderValueInGbp');
    Route::post('/admin/setRequestPrice','AdminController@setRequestPrice');
    Route::post('/admin/logout','Auth\AdminLoginController@adminLogout');
    Route::post('/admin/changeRequestStatus','AdminController@changeRequestStatus');
    Route::post('/create/admin','AdminController@createAdmin')->name('create.admin');
    Route::get('/admin/index','AdminController@showIndex')->name('admin.index');
    Route::get('/admin/shared/links','AdminController@showSharedLinks')->name('admin.request.management');

    Route::get('/addProduct','ProductController@addProduct')->name('admin.addProduct');
    Route::post('/storeProduct','ProductController@store');
    Route::get('/productList','ProductController@showProducts')->name('Product.list');
    Route::get('/indivisualProduct/{id}','ProductController@showProductDetail');
    Route::get('/updateProduct/{id}','ProductController@updateProduct');
    Route::post('/updateProduct/{id}','ProductController@update');

    Route::get('/admin/allOrders','ProductController@orders')->name('admin.orders');
    Route::post('/admin/changeOrderStatus','ProductController@changeOrderStatus');
    Route::get('/admin/indivisualOrderDetail/{id}','ProductController@indivisualOrderDetail');
    Route::post('/admin/storeFile','ProductController@storeFile')->name('admin.store');
    Route::post('/admin/order/orderDiscussion','ProductController@storeOrderDiscussion');
    Route::get('/showLog/{id}','ProductController@logViewer');

    Route::post('/admin/assignEmployee','ProductController@employeeAssigner');
    Route::get('/admin/create','AdminController@showRegistrationForm');
    Route::post('/admin/user/register','AdminController@registerUser');
    Route::post('/admin/changePointDiscount','AdminController@pointManager');

    //Routes for category
    Route::post('/admin/addCatagory','AdminController@addCatagory')->name('admin.add.catagory');
    Route::post('/admin/update/category/{id}','AdminController@updateCatagory');
    Route::get('/admin/delete/category/{id}','AdminController@deleteCatagory');

    Route::post('/admin/addSubCatagory','AdminController@addSubCatagory')->name('admin.add.sub.catagory');
    Route::post('/admin/update/subcategory/{id}','AdminController@updateSubCatagory');
    Route::get('/admin/delete/subcategory/{id}','AdminController@deleteSubCatagory');

    Route::post('/admin/addItemCatagory','AdminController@addItemCatagory')->name('admin.add.item.catagory');
    Route::post('/admin/update/sub/subcategory/{id}','AdminController@updateItemCatagory');
    Route::get('/admin/delete/sub/subcategory/{id}','AdminController@deleteItemCatagory');



    Route::get('/admin/employee/management','AdminController@employeeManagement')->name('admin.employee.management');
    Route::get('/admin/employee/update/{id}','AdminController@employeeUpdate');
    Route::post('/admin/employee/update/{id}','AdminController@Update');
    Route::post('/admin/deleteEmployee','AdminController@deleteEmployee');


    Route::post('/admin/deleteProduct','ProductController@deleteProduct');
    Route::post('/admin/addSlide','AdminController@addSlide');
    Route::get('/admin/deleteSlide/{id}','AdminController@deleteSlide');
    Route::get('/user/management','AdminController@showUsers')->name('admin.user.management');
    Route::post('/admin/sendmail/subscriber','AdminController@sendMail')->name('send.mail.subscriber');
    Route::post('/admin/setSize','AdminController@saveSize')->name('save.size');
    Route::get('/admin/create/order','AdminController@showOrderForm')->name('admin.create.order');
    Route::post('/admin/set/order','AdminController@setOrder');
    Route::get('/admin/new/tickets','AdminController@showNewTickets')->name('admin.new.tickets');
    Route::post('/admin/changeTicketStaus','AdminController@changeTicketStatus');
    Route::get('/admin/accepted/tickets','AdminController@showAcceptedTickets')->name('admin.accepted.tickets');
    Route::post('/admin/ticket/assignEmployee','AdminController@assignEmployeeToTicket');
    Route::post('/admin/ticket/sendMail','AdminController@sendTicketSolvationMail')->name('send.mail.ticketOwner');

    //validator url//

    Route::get('/checkSize','AdminController@checkSize');
    Route::get('/checkGBPlower','AdminController@checkGBPlower');
    Route::get('/checkCategory','AdminController@checkCategory');
    Route::get('/checkEmail','AdminController@checkEmail');
    Route::get('/checkShowcase','AdminController@checkShowcase');
    Route::get('/checkWebsite','AdminController@checkWebsite');

    Route::post('/admin/update/gbp/rate/{id}','AdminController@changeGBP');
    Route::get('/admin/delete/gbp/{id}','AdminController@deleteGBP');
    Route::post('/admin/add/gbp','AdminController@addGBP')->name('admin.add.gbp');
    Route::post('/admin/add/shipping/cost','AdminController@addShippingCost')->name('admin.add.shipping.cost');
    Route::post('/admin/add/delivery/charge','AdminController@addDeliveryCharge')->name('admin.add.delivery.charge');
    Route::post('/admin/update/deliver/charge/{id}','AdminController@updateDeliveryCharge');
    Route::get('/admin/delete/delivery/charge/{id}','AdminController@deleteDeliveryCharge');
    Route::post('/admin/change/shipping/cost','AdminController@changeShippingCost');



    Route::get('/admin/index/management','AdminController@IndexSettings')->name('admin.index.management');
    Route::post('/admin/add/showcase','AdminController@addShowcase');
    Route::post('/admin/add/existing/showcase','AdminController@addExistingShowcase');
    Route::get('/admin/showcase/delete/{id}','AdminController@deleteShowcase');

    Route::post('/admin/update/cost/estimation/website/{id}','AdminController@updateCostEstimationWebsite');
    Route::post('/admin/add/cost/estimation/website','AdminController@addCostEstimationWebsite');
    Route::get('/admin/delete/cost/estimation/website/{id}','AdminController@deleteCostEstimationWebsite');


});
Route::get('/employee/register','Auth\EmployeeRegisterController@showRegistrationForm')->name('employee.register');
Route::post('/employee/register','Auth\EmployeeRegisterController@register')->name('employee.register.submit');


///user routes---------------------------------
Route::group(['middleware' => ['web']], function () {
    Route::get('/login/facebook','Auth\LoginController@redirectToProvider');
    Route::get('/login/facebook/redirect','Auth\LoginController@handleProviderCallback');
});

Route::post('/searchItem','IndexController@itemFinder');
Route::post('/create/ticket','UserController@createTicket');
Route::get('/','IndexController@showIndex');
Route::get('/cart','IndexController@showCart')->name('user.cart');
Route::get('/productDetail/{id}','IndexController@showProductDetail');
Route::get('/item/{category}','IndexController@itemWiseProduct');
Route::get('/subCatagoryWiseProduct/{sub_catagory}','IndexController@SubCatagoryWiseProduct');

Route::get('/account/settings','UserController@showAccountSettingsPage')->name('user.account.settings');
Route::post('/update/personalinfo/{id}','UserController@updatePersonalInfo');
Route::post('/update/password/{id}','UserController@changePassword');

Route::get('/addToWishlist/{id}','UserController@addToWishlist');
Route::get('/showWishList','UserController@showWishList')->name('user.wishList');
Route::post('/subscribe','UserController@subscriber')->name('user.subscribe');
Route::post('/subscribe/unauth','IndexController@subscriber')->name('unauth.user.subscribe');
Route::post('/removeWish','UserController@removeWish')->name('user.removeWish');

Route::get('/orderPlacementInfo/address','OrderController@showOrderPlacement');
Route::get('/orderPlacementInfo/checkOut','OrderController@showCheckOut');
Route::post('/checkOut','OrderController@confirmCheckout');
Route::get('/userOrderDetail','OrderController@showUserOrderDetail')->name('user.order');
Route::get('/orderPlacementInfo/payment','OrderController@showOrderPayment');
Route::get('/indivisualOrderDetail/{id}','OrderController@showIndivisualOrder');
Route::get('/indivisualOrderTrack/{id}','OrderController@showOrderTrack');

Route::post('/share/link','IndexController@storeLink')->name('user.send.link');
Route::get('/search','IndexController@search')->name('user.search');

Route::get('/share/link','UserController@shareLink')->name('user.sharelink');
Route::get('/activate/{id}','IndexController@activateUser');
Route::post('/send/password/reset/link','IndexController@sendPasswordChangeLink')->name('send.password.reset.link');
Route::get('/password/reset/show/form/{id}','IndexController@showPasswordReset');
Route::post('/new/reset/password/{id}','IndexController@changePassword');
Route::post('/check/product/checkOut','OrderController@checkOrderedProductAvailability');
Route::get('/contact','IndexController@showContact');
