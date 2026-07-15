<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================
// AUTH
// ============================

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::process');
$routes->get('/logout', 'Auth::logout');

$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

$routes->get('/register', 'Auth::register');
$routes->post('/register/process', 'Auth::registerProcess');

// ============================
// BOOK
// ============================

$routes->get('/books', 'BookController::index');

$routes->get('/books/create', 'BookController::create');

$routes->post('/books/store', 'BookController::store');

$routes->get('/books/edit/(:num)', 'BookController::edit/$1');

$routes->post('/books/update/(:num)', 'BookController::update/$1');

$routes->get('/books/delete/(:num)', 'BookController::delete/$1');

$routes->get('/books/detail/(:num)', 'BookController::detail/$1');


// API Open Library
$routes->get('/books/fetch/(:any)', 'Books::fetchBook/$1');


// ============================
// ADMIN
// ============================

$routes->group('admin', ['filter' => 'auth:1'], function($routes){

    $routes->get('dashboard', 'Admin::index');

});


// ============================
// MEMBER
// ============================

$routes->group('member', ['filter' => 'auth:3'], function($routes){

    $routes->get('dashboard', 'Member::index');

});


// ============================
// PEMINJAMAN
// ============================

// Daftar peminjaman
$routes->get('/pinjam', 'Peminjaman::index');

// Form memilih lama peminjaman
$routes->get('/pinjam/form/(:num)', 'Peminjaman::form/$1');

// Simpan peminjaman
$routes->post('/pinjam/store', 'Peminjaman::store');






// ============================
// REST API
// ============================

$routes->group('api', ['filter' => 'apiKey'], function($routes){

    $routes->get('books', 'Api\BooksApi::index');

    $routes->get('books/(:num)', 'Api\BooksApi::show/$1');

    $routes->post('books', 'Api\BooksApi::create');

    $routes->put('books/(:num)', 'Api\BooksApi::update/$1');

    $routes->delete('books/(:num)', 'Api\BooksApi::delete/$1');

});

// ============================
// STAFF
// ============================
$routes->get('/staff','Staff::index');

$routes->get('/staff/create','Staff::create');

$routes->post('/staff/store','Staff::store');

$routes->get('/staff/delete/(:num)','Staff::delete/$1');

$routes->get('/users','UserController::index');

$routes->get('/users/role/(:num)','UserController::role/$1');

$routes->get('/users/delete/(:num)','UserController::delete/$1');

$routes->post('users/storeStaff', 'UserController::storeStaff');

// ============================
// Detail Peminjaman
// ============================

$routes->get('/pinjam/detail/(:num)', 'Peminjaman::detail/$1');

$routes->get('pinjam/kembali/(:num)', 'Peminjaman::kembali/$1');

// =============================
// MANAJEMEN PEMINJAMAN
// =============================

$routes->get('/peminjaman','LoanController::index');

$routes->get('/peminjaman/detail/(:num)','LoanController::detail/$1');

$routes->get('/peminjaman/return/(:num)','LoanController::returnBook/$1');

// =============================
// MIDTRANS PAYMENT
// =============================
$routes->get('/payment/pay/(:num)', 'Payment::pay/$1');

$routes->post('/payment/callback', 'Payment::callback');

$routes->get('/payment/finish', 'Payment::finish');

$routes->post('/payment/notification', 'Payment::notification');

$routes->get('/test-wa', 'TestWa::index');