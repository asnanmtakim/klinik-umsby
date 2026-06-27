<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
// Home
$routes->get('/', 'Home::index', ['as' => 'home']);

// Baksos
$routes->get('baktisosial', 'Baksos::index', ['as' => 'baksos']);
$routes->post('baktisosial/register', 'Baksos::store', ['as' => 'baksos-register']);
$routes->get('baktisosial/success', 'Baksos::success', ['as' => 'baksos-success']);

// Auth
service('auth')->routes($routes);

$routes->group('dashboard', ['namespace' => 'App\Controllers\Dashboard', 'filter' => 'session'], static function ($routes) {
    $routes->get('/', 'Dashboard::index', ['as' => 'dashboard']);

    // Admin > Bakti Sosial
    $routes->get('baksos/services', 'AdminBaksos::services', ['as' => 'admin-baksos-services']);
    $routes->post('baksos/services/all', 'AdminBaksos::servicesAll', ['as' => 'admin-baksos-services-all']);
    $routes->post('baksos/services/one', 'AdminBaksos::servicesOne', ['as' => 'admin-baksos-services-one']);
    $routes->post('baksos/services/save', 'AdminBaksos::servicesSave', ['as' => 'admin-baksos-services-save']);
    $routes->post('baksos/services/delete', 'AdminBaksos::servicesDelete', ['as' => 'admin-baksos-services-delete']);

    $routes->get('baksos/registrations', 'AdminBaksos::registrations', ['as' => 'admin-baksos-registrations']);
    $routes->post('baksos/registrations/all', 'AdminBaksos::registrationsAll', ['as' => 'admin-baksos-registrations-all']);
    $routes->post('baksos/registrations/delete', 'AdminBaksos::registrationsDelete', ['as' => 'admin-baksos-registrations-delete']);

    // Admin > Settings
    $routes->get('settings', 'Settings::index', ['as' => 'settings']);
});
