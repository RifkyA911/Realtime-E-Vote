<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth & Language Routes
$route['auth/login'] = 'auth/login';
$route['auth/authenticate'] = 'auth/authenticate';
$route['auth/tap_card'] = 'auth/tap_card';
$route['auth/logout'] = 'auth/logout';
$route['lang/switch/(:any)'] = 'lang/switch_lang/$1';

// Documentation Route
$route['docs'] = 'docs/index';

// E-Vote Routes
$route['dashboard'] = 'dashboard/index';
$route['dashboard/live_stats'] = 'dashboard/get_live_stats';
$route['dashboard/print_rekap'] = 'dashboard/print_rekap';

$route['candidate'] = 'candidate/index';
$route['candidate/create'] = 'candidate/create';
$route['candidate/store'] = 'candidate/store';
$route['candidate/edit/(:num)'] = 'candidate/edit/$1';
$route['candidate/update/(:num)'] = 'candidate/update/$1';
$route['candidate/delete/(:num)'] = 'candidate/delete/$1';
$route['candidate/detail/(:num)'] = 'candidate/detail/$1';

$route['voter'] = 'voter/index';
$route['voter/create'] = 'voter/create';
$route['voter/store'] = 'voter/store';
$route['voter/edit/(:num)'] = 'voter/edit/$1';
$route['voter/update/(:num)'] = 'voter/update/$1';
$route['voter/delete/(:num)'] = 'voter/delete/$1';
$route['voter/reset_status/(:num)'] = 'voter/reset_status/$1';
$route['voter/reset_all'] = 'voter/reset_all';

$route['vote'] = 'vote/index';
$route['vote/cast'] = 'vote/cast';

$route['migrate'] = 'migrate/index';
$route['migrate/seed'] = 'migrate/seed';
$route['migrate/reset'] = 'migrate/reset';
