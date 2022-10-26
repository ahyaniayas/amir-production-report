<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/login', 'Home::login');
$routes->post('/login-process', 'Home::loginProcess');
$routes->get('/logout-process', 'Home::logoutProcess');

$routes->get('/', 'Home::index');
$routes->get('/org', 'Home::org');

$routes->get('/laporan', 'Home::laporan');
$routes->post('/laporan', 'Home::laporan');
$routes->post('/laporan/aksi-ayaktepung', 'Home::laporanAksiAyaktepung');
$routes->post('/laporan/aksi-mixing', 'Home::laporanAksiMixing');
$routes->post('/laporan/aksi-drying', 'Home::laporanAksiDrying');
$routes->get('/laporan/lihat/(:any)', 'Home::laporanLihat/$1');
$routes->get('/laporan/del/(:any)', 'Home::laporanDel/$1');
$routes->post('/laporan/del-act', 'Home::laporanDelAct');
$routes->get('/laporan/print/(:any)/(:any)', 'Home::laporanPrint/$1/$2');

$routes->get('/mnj/user', 'Home::mnjUser');
$routes->get('/mnj/user/add', 'Home::mnjUserAdd');
$routes->post('/mnj/user/add-act', 'Home::mnjUserAddAct');
$routes->get('/mnj/user/edit/(:any)', 'Home::mnjUserEdit/$1');
$routes->post('/mnj/user/edit-act', 'Home::mnjUserEditAct');
$routes->get('/mnj/user/del/(:any)', 'Home::mnjUserDel/$1');
$routes->post('/mnj/user/del-act', 'Home::mnjUserDelAct');

$routes->get('/mnj/divisi', 'Home::mnjDivisi');
$routes->get('/mnj/divisi/add', 'Home::mnjDivisiAdd');
$routes->post('/mnj/divisi/add-act', 'Home::mnjDivisiAddAct');
$routes->get('/mnj/divisi/edit/(:any)', 'Home::mnjDivisiEdit/$1');
$routes->post('/mnj/divisi/edit-act', 'Home::mnjDivisiEditAct');
$routes->get('/mnj/divisi/del/(:any)', 'Home::mnjDivisiDel/$1');
$routes->post('/mnj/divisi/del-act', 'Home::mnjDivisiDelAct');

$routes->get('/mnj/shift', 'Home::mnjShift');
$routes->get('/mnj/shift/add', 'Home::mnjShiftAdd');
$routes->post('/mnj/shift/add-act', 'Home::mnjShiftAddAct');
$routes->get('/mnj/shift/edit/(:any)', 'Home::mnjShiftEdit/$1');
$routes->post('/mnj/shift/edit-act', 'Home::mnjShiftEditAct');
$routes->get('/mnj/shift/del/(:any)', 'Home::mnjShiftDel/$1');
$routes->post('/mnj/shift/del-act', 'Home::mnjShiftDelAct');

$routes->get('/mnj/ayaktepung', 'Home::mnjAyaktepung');
$routes->get('/mnj/ayaktepung/add', 'Home::mnjAyaktepungAdd');
$routes->post('/mnj/ayaktepung/add-act', 'Home::mnjAyaktepungAddAct');
$routes->get('/mnj/ayaktepung/edit/(:any)', 'Home::mnjAyaktepungEdit/$1');
$routes->post('/mnj/ayaktepung/edit-act', 'Home::mnjAyaktepungEditAct');
$routes->get('/mnj/ayaktepung/del/(:any)', 'Home::mnjAyaktepungDel/$1');
$routes->post('/mnj/ayaktepung/del-act', 'Home::mnjAyaktepungDelAct');

$routes->get('/mnj/mixing', 'Home::mnjMixing');
$routes->get('/mnj/mixing/add', 'Home::mnjMixingAdd');
$routes->post('/mnj/mixing/add-act', 'Home::mnjMixingAddAct');
$routes->get('/mnj/mixing/edit/(:any)', 'Home::mnjMixingEdit/$1');
$routes->post('/mnj/mixing/edit-act', 'Home::mnjMixingEditAct');
$routes->get('/mnj/mixing/del/(:any)', 'Home::mnjMixingDel/$1');
$routes->post('/mnj/mixing/del-act', 'Home::mnjMixingDelAct');

$routes->get('/mnj/drying', 'Home::mnjDrying');
$routes->get('/mnj/drying/add', 'Home::mnjDryingAdd');
$routes->post('/mnj/drying/add-act', 'Home::mnjDryingAddAct');
$routes->get('/mnj/drying/edit/(:any)', 'Home::mnjDryingEdit/$1');
$routes->post('/mnj/drying/edit-act', 'Home::mnjDryingEditAct');
$routes->get('/mnj/drying/del/(:any)', 'Home::mnjDryingDel/$1');
$routes->post('/mnj/drying/del-act', 'Home::mnjDryingDelAct');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
