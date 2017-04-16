<?php
include "../config/route/session.php";

/**
 * Routes.
 */
$app->router->add("", function () use ($app) {
    // $urlstyle = dirname($_SERVER['PHP_SELF'])."/css/style.css";
    $app->view->add("take1/header", ["title" => "Hem", "urlstyle" => dirname($_SERVER['PHP_SELF'])."/css/style.css"]);
    // $app->view->add("take1/navbar");
    $app->view->add("navbar2/navbar", ["active" => ""]);
    $app->view->add("take1/home");
    $app->view->add("take1/byline");
    $app->view->add("take1/footer");


    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("report", function () use ($app) {
    // $urlstyle = dirname($_SERVER['PHP_SELF'])."/css/style.css";
    $app->view->add("take1/header", ["title" => "Redovisningar", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
    $app->view->add("navbar2/navbar", ["active" => "report"]);
    $app->view->add("take1/report");
    $app->view->add("take1/byline");
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("about", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Om", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
    $app->view->add("navbar2/navbar", ["active" => "about"]);
    $app->view->add("take1/about");
    $app->view->add("take1/byline");
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("login", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Logga in", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
    $app->view->add("navbar2/navbar", ["active" => "login"]);
    $app->view->add("login/login");
    $app->view->add("take1/byline");
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("logout", function () use ($app) {
    // $app->view->add("take1/header", ["title" => "Logga in", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "login"]);
    $app->view->add("login/logout");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("accountinfo", function () use ($app) {
    $app->view->add("take1/header", ["title" => $app->cookie->get('user', ""), "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
    $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("login/accountinfo");
    $app->view->add("take1/byline");
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("adminpage", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Administratör", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/adminpage");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("edituser", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Redigera användare", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/edituser");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("admincreateuser", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Lägg till användare", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/admincreateuser");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("deleteuser", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Ta bort användare", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/deleteuser");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("edituserprocess", function () use ($app) {
    // $app->view->add("take1/header", ["title" => "Redigera användare", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/edituserprocess");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("admincreateuserprocess", function () use ($app) {
    // $app->view->add("take1/header", ["title" => "Redigera användare", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/admincreateuserprocess");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("admineditpasswordprocess", function () use ($app) {
    // $app->view->add("take1/header", ["title" => "Redigera användare", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/admineditpasswordprocess");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("validate", function () use ($app) {
    // $app->view->add("take1/header", ["title" => "Logga in", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "Logga in"]);
    $app->view->add("login/validate");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("createuser", function () use ($app) {
    // $app->view->add("take1/header", ["title" => "Logga in", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "Logga in"]);
    $app->view->add("login/create_user");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("changedpassword", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Ändrat lösenord", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
    $app->view->add("navbar2/navbar", ["active" => "account"]);
    $app->view->add("login/changedpassword");
    $app->view->add("take1/byline");
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("welcome", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Lyckad inlogging", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
    $app->view->add("navbar2/navbar", ["active" => "Logga in"]);
    $app->view->add("login/welcome");
    $app->view->add("take1/byline");
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("guessing", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Gissa", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
    $app->view->add("navbar2/navbar", ["active" => "dropdown"]);
    $app->view->add("take1/guessing");
    $app->view->add("take1/byline");
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("calendar", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Kalender", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
    $app->view->add("navbar2/navbar", ["active" => "dropdown"]);
    $app->view->add("take1/calendar");
    $app->view->add("take1/byline");
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("cookie", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Kalender", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
    $app->view->add("navbar2/navbar", ["active" => "dropdown"]);
    $app->view->add("take1/cookie");
    $app->view->add("take1/byline");
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->addInternal("404", function () use ($app) {
        $app->view->add("take1/header", ["title" => "404", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
        $app->view->add("take1/notfound");
//     $currentRoute = $app->request->getRoute();
//     $routes = "<ul>";
//     foreach ($app->router->getAll() as $route) {
//         $routes .= "<li>'" . $route->getRule() . "'</li>";
//     }
//     $routes .= "</ul>";
//
//     $intRoutes = "<ul>";
//     foreach ($app->router->getInternal() as $route) {
//         $intRoutes .= "<li>'" . $route->getRule() . "'</li>";
//     }
//     $intRoutes .= "</ul>";
//
//     $body = <<<EOD
//     <!doctype html>
//     <meta charset="utf-8">
//     <title>404</title>
//     <h1>404 Not Found</h1>
//     <p>The route '$currentRoute' could not be found!</p>
//     <h2>Routes loaded</h2>
//     <p>The following routes are loaded:</p>
//     $routes
//     <p>The following internal routes are loaded:</p>
//     $intRoutes
// EOD;

    $app->response->setBody([$app->view, "render"])
                  ->send(404);
    // $app->response->setBody($body)->send(404);
});

$app->router->add("status", function () use ($app) {
    $data = [
        "Server" => php_uname(),
        "PHP version" => phpversion(),
        "Included files" => count(get_included_files()),
        "Memory used" => memory_get_peak_usage(true),
        "Execution time" => microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'],
    ];

    $app->response->sendJson($data);
});
