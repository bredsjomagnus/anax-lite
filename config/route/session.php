<?php

/**
 * Session Routes.
 */
$app->router->add("session", function () use ($app) {
    // $urlstyle = dirname($_SERVER['PHP_SELF'])."/css/style.css";
    $app->view->add("take1/header", ["title" => "Session", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
    $app->view->add("navbar2/navbar", ["active" => "dropdown"]);
    $app->view->add("take1/session");
    $app->view->add("take1/byline");
    $app->view->add("take1/footer");


    $app->response->setBody([$app->view, "render"])
                  ->send();
});
$app->router->add("session/increment", function () use ($app) {
    // $urlstyle = dirname($_SERVER['PHP_SELF'])."/css/style.css";
    // $app->view->add("take1/header", ["title" => "Session", "urlstyle" => dirname(dirname(dirname($_SERVER['PHP_SELF'])))."/css/style.css"]);
    // $app->view->add("take1/navbar");
    $app->view->add("take1/increment");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");


    $app->response->setBody([$app->view, "render"])
                  ->send();
});
$app->router->add("session/decrement", function () use ($app) {
    // $urlstyle = dirname($_SERVER['PHP_SELF'])."/css/style.css";
    // $app->view->add("take1/header", ["title" => "Session", "urlstyle" => dirname(dirname(dirname($_SERVER['PHP_SELF'])))."/css/style.css"]);
    // $app->view->add("take1/navbar");
    $app->view->add("take1/decrement");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");


    $app->response->setBody([$app->view, "render"])
                  ->send();
});
$app->router->add("session/status", function () use ($app) {
    // $urlstyle = dirname($_SERVER['PHP_SELF'])."/css/style.css";
    // $app->view->add("take1/header", ["title" => "Session Status", "urlstyle" => dirname(dirname(dirname($_SERVER['PHP_SELF'])))."/css/style.css"]);
    // $app->view->add("take1/navbar");
    // $app->view->add("take1/status");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");
    $app->session = new Maaa16\Session\Session();
    $app->session->start();
    $data = $app->session->status();

    $app->response->sendJson($data);


    // $app->response->setBody([$app->view, "render"])
    //               ->send();
});
$app->router->add("session/dump", function () use ($app) {
    // $urlstyle = dirname($_SERVER['PHP_SELF'])."/css/style.css";
    $app->view->add("take1/header", ["title" => "Sessiondump", "urlstyle" => dirname(dirname(dirname($_SERVER['PHP_SELF'])))."/css/style.css"]);
    $app->view->add("navbar2/navbar", ["active" => "dropdown"]);
    $app->view->add("take1/sessiondump");
    $app->view->add("take1/byline");
    $app->view->add("take1/footer");


    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("session/destroy", function () use ($app) {
    // $urlstyle = dirname($_SERVER['PHP_SELF'])."/css/style.css";
    // $app->view->add("take1/header", ["title" => "Session", "urlstyle" => dirname(dirname(dirname($_SERVER['PHP_SELF'])))."/css/style.css"]);
    // $app->view->add("take1/navbar");
    $app->view->add("take1/destroysession");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");


    $app->response->setBody([$app->view, "render"])
                  ->send();
});
