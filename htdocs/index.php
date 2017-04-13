<?php
/**
 * Bootstrap the framework.
 */
// Where are all the files? Booth are needed by Anax.
define("ANAX_INSTALL_PATH", realpath(__DIR__ . "/.."));
define("ANAX_APP_PATH", ANAX_INSTALL_PATH);

// Include essentials
require ANAX_INSTALL_PATH . "/config/error_reporting.php";

// Get the autoloader by using composers version.
require ANAX_INSTALL_PATH . "/vendor/autoload.php";

// Add all resources to $app
$app = new \Maaa16\App\App();
$app->request   = new \Anax\Request\Request();
$app->response  = new \Anax\Response\Response();
$app->url       = new \Anax\Url\Url();
$app->router    = new \Anax\Route\RouterInjectable();
$app->view      = new \Anax\View\ViewContainer();
$app->navbar    = new \Maaa16\Navbar\Navbar();
$app->session   = new \Maaa16\Session\Session();
$app->cookie    = new \Maaa16\Cookie\Cookie();
$app->database  = new \Maaa16\Database\Database();

// var_dump($app);
$app->session->start();

// Inject $app into the view container for use in view files.
// Inject $app into the view container for use in view files.
$app->view->setApp($app);

// Inject $app into navbar to get access to urls
$app->navbar->setApp($app);

// Update view configuration with values from config file.
$app->view->configure("view.php");

$app->request->init();

// Set default values from the request object.
$app->url->setSiteUrl($app->request->getSiteUrl());
$app->url->setBaseUrl($app->request->getBaseUrl());
$app->url->setStaticSiteUrl($app->request->getSiteUrl());
$app->url->setStaticBaseUrl($app->request->getBaseUrl());
$app->url->setScriptName($app->request->getScriptName());

// Update url configuration with values from config file.
$app->url->configure("url.php");
$app->url->setDefaultsFromConfiguration();

$app->navbar->configure("navbar.php");
$app->navbar->setDefaultsFromConfiguration();

$app->database->configure("database.php");
$app->database->setDefaultsFromConfiguration();


// $app->database->connect();
// Create the router
// $router = new \Anax\Route\RouterInjectable();

// Load the routes
require ANAX_INSTALL_PATH . "/config/route.php";

/**
 * Routekataloger
 */
require ANAX_INSTALL_PATH . "/config/route/internal.php";
require ANAX_INSTALL_PATH . "/config/route/base.php";

// Leave to router to match incoming request to routes
$app->router->handle($app->request->getRoute(), $app->request->getMethod());
