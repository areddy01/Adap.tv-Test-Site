<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['default_controller'] = 'pages';
$route['cms/upload/(:any)'] = 'cms/upload/$1';

$route['solutions/publishers/(:any)'] = 'pages/solutionspublishers/$1';
$route['solutions/agencies/(:any)'] = 'pages/solutionsagencies/$1';
$route['solutions/(:any)'] = 'pages/solutions/$1';
$route['solutions'] = 'pages/solutions';

$route['products/(:any)'] = 'pages/products/$1';
$route['products'] = 'pages/products';

$route['careers/(:any)'] = 'pages/careers/$1';
$route['careers'] = 'pages/careers';

$route['news'] = 'pages/news';
$route['news/(:any)'] = 'pages/news/$1';
$route['articles/(:any)'] = 'pages/articles/$1';
$route['company'] = 'pages/company';
$route['contact'] = 'pages/contact';

$route['optout'] = 'pages/optout';
$route['privacy'] = 'pages/privacy';

$route['careervideo'] = 'pages/careervideo';
$route['upfrontvideo'] = 'pages/upfrontvideo';

$route['direct/careervideo'] = 'pages/careervideodirect';
$route['direct/upfrontvideo'] = 'pages/upfrontvideodirect';


$route['company-careers-listings.php'] = 'pages/careers/openings';


$route['internal/(:any)'] = 'internal/view/$1';

$route['404_override'] = 'pages/redirect';



/* End of file routes.php */
/* Location: ./application/config/routes.php */