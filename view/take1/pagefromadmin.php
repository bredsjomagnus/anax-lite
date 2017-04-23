<?php
if (isset($_GET['route'])) {
    $app->database->connect();
    $route = $_GET['route'];
    $sql = "SELECT data, filter, title FROM content WHERE path = ?";
    $res = $app->database->execute($sql, [$route]);
    $textfilter = new Maaa16\Textfilter\Textfilter();
    foreach ($res as $row) {
        $title = strtoupper($row->title);
        $content = $row->data;
        $filter = $row->filter;
        $filteredContent = $textfilter->doFilter($content, $filter);
    }
}


?>
<div class="page">
    <div class="container">
        <h1><?= $title ?></h1>
        <div class="row">
            <?= $filteredContent ?>
        </div>
    </div>

</div>
