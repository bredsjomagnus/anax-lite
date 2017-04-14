<?php
$passcookie = $app->cookie->get('password') ? "är sparat" : "är inte sparat";
?>
<div class="page">
    <div class="container">
        <h1>Cookietest</h1>
        <?= "<p>&#36;_COOKIE['user'] = " . $app->cookie->get('user', "inte satt") . "</p>"; ?>
        <?= "<p>&#36;_COOKIE['password'] " . $passcookie . "</p>"; ?>
    </div>
</div>
