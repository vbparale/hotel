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
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['admin/daily_reports/:any'] = 'admin/daily_reports';
$route['admin/daily_sales_reports/:any'] = 'admin/daily_sales_reports';
$route['admin/monthly_reports/:any'] = 'admin/monthly_reports';
$route['admin/monthly_sales_reports/:any'] = 'admin/monthly_sales_reports';
$route['admin/view_invoice/:num/:num'] = 'admin/view_invoice';
$route['admin/guest_details/:num/'] = 'admin/guest_details';
$route['admin/guest_details/:any/:any/:num'] = 'admin/view_available_rooms';
/*$route['admin/view_invoice_group/:num'] = 'admin/view_invoice_group';*/

$route['frontdesk/view_invoice/:num'] = 'frontdesk/view_invoice';
$route['frontdesk/guest_details/:num/'] = 'frontdesk/guest_details';

$route['cashier/add_item/:num'] = 'cashier/add_item';
$route['cashier/edit_item/:num'] = 'cashier/edit_item';
$route['cashier/delete_item/:num'] = 'cashier/delete_item';
$route['cashier/search_products/:any'] = 'cashier/search_products';
