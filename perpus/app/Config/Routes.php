<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::process');
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/logout', 'Auth::logout');

return redirect()->to('/dashboard');

$routes->group('admin', ['filter' => 'auth:1'], function($routes){
    $routes->get('dashboard', 'Admin::index');
});

$routes->group('member', ['filter' => 'auth:3'], function($routes){
    $routes->get('dashboard', 'Member::index');
});
