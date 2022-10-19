<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Customer');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function () {
    return view('errors/404');
});
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
/**
 * Customer Side
 */
$routes->get('/', 'Customer::auth');
$routes->post('/order', 'Customer::customerGetOrder');
$routes->get('/order', 'Customer::customerOrderDetail');
$routes->post('/order/deletephoto', 'Customer::customerDeletePhoto');
$routes->post('/order/confirm', 'Customer::customerConfirm');


/**
 * Photo Management
 */
$routes->post('/order/upload', 'Customer::customerUpload');


/**
 * Admin Side
 */
$routes->get('/admin', 'Admin::index');

/**
 * Orders Management
 */
$routes->get('/admin/orders', 'Admin::orders');
$routes->post('/admin/orders/uploadinglist', 'Admin::ordersGetUploading');
$routes->post('/admin/orders/queuedlist', 'Admin::ordersGetQueued');
$routes->post('/admin/orders/processinglist', 'Admin::ordersGetProcessing');
$routes->post('/admin/orders/shippinglist', 'Admin::ordersGetShipping');
$routes->post('/admin/orders/completedlist', 'Admin::ordersGetCompleted');
$routes->post('/admin/orders/add', 'Admin::ordersAdd');
$routes->post('/admin/orders/delete', 'Admin::ordersDelete');
$routes->post('/admin/orders/update', 'Admin::ordersUpdate');
$routes->post('/admin/orders/updatestatus', 'Admin::ordersUpdateStatus');
$routes->post('/admin/orders/download', 'Admin::ordersDownload');
$routes->get('/admin/orders/photosdownload', 'Admin::photosDownload');
$routes->post('/admin/orders/finished', 'Admin::ordersFinished');
$routes->post('/admin/orders/completed', 'Admin::ordersCompleted');

/**
 * Admins Management
 */
$routes->get('/admin/administrators', 'Admin::administrators');
$routes->post('/admin/administrators/add', 'Admin::administratorsAdd');
$routes->post('/admin/administrators/reset', 'Admin::administratorsReset');




/**
 * Authentication
 */
$routes->get('/login', 'Auth::login');
$routes->post('/auth', 'Auth::auth');
$routes->get('/logout', 'Auth::logout');

/**
 * API inject
 */
$routes->post('/api/v1/add-admin', 'Api::addAdmin'); //require name,username,password & api_password



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
