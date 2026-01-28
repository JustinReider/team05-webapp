<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);
$routes->get('/', 'Home::index');

$routes->get('/spalten', 'Spalten::index');
$routes->get('/spalten/new', 'Spalten::getNew');
$routes->get('/spalten/(:num)', 'Spalten::getEdit/$1');
$routes->post('/spalten/save', 'Spalten::postSave');
$routes->post('/spalten/save/(:num)', 'Spalten::postSave/$1');
$routes->post('/spalten/delete/(:num)', 'Spalten::postDelete/$1');

$routes->get('/boards', 'Boards::getIndex');
$routes->get('/boards/new', 'Boards::getNew');
$routes->get('/boards/(:num)', 'Boards::getEdit/$1');
$routes->post('/boards/save', 'Boards::postSave');
$routes->post('/boards/save/(:num)', 'Boards::postSave/$1');
$routes->post('/boards/delete/(:num)', 'Boards::postDelete/$1');

$routes->get('/tasks', 'Tasks::getIndex');
$routes->get('/tasks/new', 'Tasks::getNew');
$routes->get('/tasks/(:num)', 'Tasks::getEdit/$1');
$routes->post('/tasks/save', 'Tasks::postSave');
$routes->post('/tasks/save/(:num)', 'Tasks::postSave/$1');
$routes->post('/tasks/delete/(:num)', 'Tasks::postDelete/$1');
