<?php
$app->database->connect();
$sql = "SELECT path FROM content WHERE status = ?";
$res = $app->database->executeFetchAll($sql, ['Published']);
$routes = "<ul>";
foreach ($res as $route) {
    $routes .= "<li>'" . $route->path . "'</li>";
}
$routes .= "</ul>";
?>
<h1>404 Not Found</h1>
<p>The route could not be found!</p>
<h2>Routes loaded</h2>
<p>The following routes for published databasepages are loaded:</p>
<?= $routes ?>
