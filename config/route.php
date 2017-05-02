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

$app->router->add("adminpageusers", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Administratör", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/adminpageusers");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("adminpagecontent", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Administratör", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/adminpagecontent");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("adminpagewebbshop", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Administratör", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/adminpagewebbshop");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("adminwebbshopaddtoshelfrow", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Administratör", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/adminwebbshopaddtoshelfrow");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("adminwebbshopnewshelfrow", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Administratör", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/adminwebbshopnewshelfrow");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("adminvieworder", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Administratör", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/adminvieworder");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("adminviewinvoice", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Administratör", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/adminviewinvoice");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("admincreatecontent", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Administratör", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/admincreatecontent");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("admincreateproduct", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Administratör", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/admincreateproduct");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("admineditcontent", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Administratör", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/admineditcontent");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("admineditproduct", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Administratör", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/admineditproduct");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("admineditcontentprocess", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Administratör", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/admineditcontentprocess");
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

$app->router->add("adminpublishcontent", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Ta bort innehåll", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/adminpublishcontent");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("admindeletecontent", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Ta bort innehåll", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/admindeletecontent");
    // $app->view->add("take1/byline");
    // $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                  ->send();
});

$app->router->add("adminterminatecontent", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Ta bort innehåll", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/adminstyle.css"]);
    // $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
    $app->view->add("take1/adminterminatecontent");
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

$app->router->add("page", function () use ($app) {
        $app->view->add("take1/header", ["title" => "page", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
        $app->view->add("navbar2/navbar", ["active" => "dropdown"]);
        $app->view->add("take1/page");
        $app->view->add("take1/byline");
        $app->view->add("take1/footer");
        $app->response->setBody([$app->view, "render"])
                      ->send();
        // $app->response->setBody($body)->send(404);
});

$app->router->add("blocktest", function () use ($app) {
        $app->view->add("take1/header", ["title" => "page", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
        $app->view->add("navbar2/navbar", ["active" => "dropdown"]);
        $app->view->add("take1/blocktest");
        $app->view->add("take1/byline");
        $app->view->add("take1/footer");
        $app->response->setBody([$app->view, "render"])
                      ->send();
        // $app->response->setBody($body)->send(404);
});

$app->router->add("block/{blockslug}", function ($blockslug) use ($app) {
        // $app->view->add("take1/header", ["title" => "page", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
        // $app->view->add("navbar2/navbar", ["active" => "dropdown"]);
        $app->view->add("take1/block", ["blockslug" => $blockslug]);
        // $app->view->add("take1/byline");
        // $app->view->add("take1/footer");
        // $blockdata = $blockslug;
        $app->response->setBody([$app->view, "render"])
                      ->send();
        // $app->response->setBody($body)->send(404);
});

$app->router->add("blog", function () use ($app) {
        $app->view->add("take1/header", ["title" => "Blogg", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
        $app->view->add("navbar2/navbar", ["active" => "dropdown"]);
        $app->view->add("take1/blog");
        $app->view->add("take1/byline");
        $app->view->add("take1/footer");
        $app->response->setBody([$app->view, "render"])
                      ->send();
        // $app->response->setBody($body)->send(404);
});

$app->router->add("blogpost", function () use ($app) {
        $app->view->add("take1/header", ["title" => "Bloggpost", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
        $app->view->add("navbar2/navbar", ["active" => "dropdown"]);
        $app->view->add("take1/blogpost");
        $app->view->add("take1/byline");
        $app->view->add("take1/footer");
        $app->response->setBody([$app->view, "render"])
                      ->send();
        // $app->response->setBody($body)->send(404);
});

$app->router->add("createblogpost", function () use ($app) {
        $app->view->add("take1/header", ["title" => "Bloggpost", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
        $app->view->add("navbar2/navbar", ["active" => "dropdown"]);
        $app->view->add("take1/createblogpost");
        $app->view->add("take1/byline");
        $app->view->add("take1/footer");
        $app->response->setBody([$app->view, "render"])
                      ->send();
        // $app->response->setBody($body)->send(404);
});

$app->router->add("pagefromadmin", function () use ($app) {
        $app->view->add("take1/header", ["title" => "page", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
        $app->view->add("navbar2/navbar", ["active" => "accountinfo"]);
        $app->view->add("take1/pagefromadmin");
        $app->view->add("take1/byline");
        $app->view->add("take1/footer");
        $app->response->setBody([$app->view, "render"])
                      ->send();
        // $app->response->setBody($body)->send(404);
});


$app->router->addInternal("404", function () use ($app) {
        $app->view->add("take1/header", ["title" => "404", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
        $app->view->add("take1/notfound");

    $app->response->setBody([$app->view, "render"])
                  ->send(404);
});

$app->router->add("404dbpage", function () use ($app) {
        $app->view->add("take1/header", ["title" => "404", "urlstyle" => dirname(dirname($_SERVER['PHP_SELF']))."/css/style.css"]);
        $app->view->add("take1/notfounddbpage");

    $app->response->setBody([$app->view, "render"])
                  ->send(404);
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
