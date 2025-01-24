<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Siswa::index');
$routes->post('siswa/simpan', 'Siswa::simpan');
$routes->get('siswa/hapus/(:num)', 'Siswa::hapus/$1');
$routes->get('siswa/getDataSiswa/(:num)', 'Siswa::getDataSiswa/$1');






