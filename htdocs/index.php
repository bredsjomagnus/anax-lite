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
$app->request = new \Anax\Request\Request();
$app->response = new \Anax\Response\Response();
$app->url     = new \Anax\Url\Url();
$app->router  = new \Anax\Route\RouterInjectable();
$app->view     = new \Anax\View\ViewContainer();

// var_dump($app);

// Inject $app into the view container for use in view files.
$app->view->setApp($app);

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

// Create the router
// $router = new \Anax\Route\RouterInjectable();

// Load the routes
require ANAX_INSTALL_PATH . "/config/route.php";

/**
 * Routes. Enligt instruktionen
 */
// require __DIR__ . "/route/internal.php";
// require __DIR__ . "/route/base.php";

/**
 * Routes. Mitt eget försök
 */
// require ANAX_INSTALL_PATH . "/route/internal.php";
// require ANAX_INSTALL_PATH . "/route/base.php";



// Leave to router to match incoming request to routes
$app->router->handle($app->request->getRoute(), $app->request->getMethod());


// Create some urls.
// $aUrl = $app->url->create("");
// echo "<p><a href='$aUrl'>The index url, home</a> ($aUrl)";
//
// $aUrl = $app->url->create("some/route");
// echo "<p><a href='$aUrl'>Url to some/route</a> ($aUrl)";
//
// $aUrl = $app->url->create("some/where/some/route");
// echo "<p><a href='$aUrl'>Another url to some/where/some/route</a> ($aUrl)";


// $urlHome  = $app->url->create("");
// $urlAbout = $app->url->create("about");
// $navbar = <<<EOD
// <navbar>
//     <a href="$urlHome">Home</a> |
//     <a href="$urlAbout">About</a>
// </navbar>
// EOD;
