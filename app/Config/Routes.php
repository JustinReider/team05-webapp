<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);
$routes->get('/', 'Home::index');
$routes->get('/spalten', 'Spalten::index');
$routes->get('/spalten/new', 'Spalten::new');
$routes->get('/tasks', 'Tasks::getIndex');
$routes->get('/tasks/new', 'Tasks::getNew');
$routes->get('/tasks/(:num)', 'Tasks::getEdit/$1');
$routes->post('/tasks/save/(:num)', 'Tasks::postSave/$1');
$routes->post('/tasks/save', 'Tasks::postSave');
$routes->post('/tasks/delete/(:num)', 'Tasks::postDelete/$1');
