<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('UserController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
/**
 * --------------------------------------------------------------------
 * Route Users
 * --------------------------------------------------------------------
 */
$routes->get('/', 'BaseController::index');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/registrar-marca', 'UserController::company_register');
$routes->get('/registrar-influencer', 'UserController::influencer_register');
$routes->get('/editar-perfil', 'UserController::edit_profile');
$routes->get('/perfil', 'UserController::profileUser');
$routes->get('/listado', 'UserController::list_employee');
$routes->get('/crear-experiencia', 'UserController::create_view_exp_profile');
$routes->get('/editar-experiencia/(:num)', 'UserController::edit_view_exp_profile/$1');
$routes->get('/eliminar-experiencia/(:num)', 'UserController::delete_exp_profile/$1');
$routes->get('/hello-world', 'UserController::hello_world');
$routes->post('/registration', 'UserController::registration');
$routes->post('/updateUser', 'UserController::updateUser');
$routes->post('/insert_exp_user', 'UserController::insert_exp_user');
$routes->post('/edit_exp_user', 'UserController::edit_exp_user');
$routes->post('/subcategorias', 'UserController::subcategory');

/**
 * --------------------------------------------------------------------
 * Route Campañas
 * --------------------------------------------------------------------
 */
$routes->get('/inicio', 'CampaignController::inicio');
$routes->get('/crear-campaña', 'CampaignController::create_view_campaign');
$routes->post('/insert_campaign', 'CampaignController::insert_campaign');
$routes->get('/buscar-campañas', 'CampaignController::searchCampaign');
$routes->get('/campañas', 'CampaignController::campaign');
$routes->get('/aplicar-campaña', 'CampaignController::applyCampaign');
$routes->get('/mis-campañas', 'CampaignController::getInfluencers');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
