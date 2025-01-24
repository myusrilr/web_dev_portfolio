<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'formController::formKids');
$routes->get('/coding', 'formController::formCoding');
$routes->get('/adult', 'formController::formAdult');
$routes->post('/submit', 'formController::submit');
$routes->get('/success', 'FormController::success');
