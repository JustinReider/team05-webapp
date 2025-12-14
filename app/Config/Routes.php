<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);
$routes->get('/', 'Home::index');
$routes->get('/spalten', 'Spalten::index');
$routes->get('/spalten/new', 'Spalten::new');
