<div class="page">
    <div class="container">
        <h1>Cookietest</h1>
        <?= "<p>&#36;_COOKIE['user'] = " . $app->cookie->get('user', "inte satt") . "</p>"; ?>
        <?= "<p>&#36;_COOKIE['password'] = " . $app->cookie->get('password', "inte satt") . "</p>"; ?>
    </div>
</div>
