<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);
$routes->get('/', 'Home::index');
$routes->get('/spalten', 'Spalten::index');
$routes->get('/spalten/new', 'Spalten::new');
$routes->get('tasks', 'Tasks::getIndex');
$routes->get('tasks/new', 'Tasks::getNew');
$routes->post('tasks/save', 'Tasks::postSave');

