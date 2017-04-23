<?php
$navbar = "";
$filteredContent = "";
$title= "";
$app->database->connect();
$sql = "SELECT path, data, title, filter FROM content WHERE type = ? AND status = ?";
if ($res = $app->database->execute($sql, ['page', 'Published'])) {
    $navbar = "<navbar>";
    foreach ($res as $row) {
        $navbar .= "<a href='?route=".$row->path."'>$row->title</a> | ";
    }
    $navbar .= "</navbar>";
}
if (isset($_GET['route'])) {
    $app->database->connect();
    $route = $_GET['route'];
    $sql = "SELECT data, filter, title FROM content WHERE type = ? AND path = ? AND status = ?";
    if ($res = $app->database->executeFetchAll($sql, ['page', $route, 'Published'])) {
        $textfilter = new Maaa16\Textfilter\Textfilter();
        foreach ($res as $row) {
            $title = strtoupper($row->title);
            $content = $row->data;
            $filter = $row->filter;
            $filteredContent = $textfilter->doFilter($content, $filter);
        }
    } else {
        header('Location: 404dbpage');
    }
}
?>

<div class="page">
    <div class="container">
        <div class="row">
            <?= $navbar ?>
        </div>
        <div class="pillow-50">

        </div>
        <!-- <div class="row">
            <h4><?= $title ?></h4>
        </div>
        <hr> -->
        <div class="row">
            <?= $filteredContent ?>
        </div>
    </div>

</div>
