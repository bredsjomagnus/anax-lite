<?php
$app->database->connect();
$sql = "SELECT
            *,
            DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
            DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
        FROM content
        WHERE type = ? AND status = ?
        ORDER BY published_iso8601 DESC";
$res = $app->database->executeFetchAll($sql, ['post', 'Published']);
$bloggs = "";
$textfilter = new Maaa16\Textfilter\Textfilter();
foreach ($res as $row) {
    $blogContent = $row->data;
    $blogFilter = $row->filter;
    $filteradContent = $textfilter->doFilter($blogContent, $blogFilter);
    $bloggs .= "<section>
                    <header>
                        <h1><a href='".$app->url->create('blogpost')."?blogslug=".htmlentities($row->slug)."'>".$row->title."</a></h1>
                        <p><i>Senast uppdaterad: <time datetime='".htmlentities($row->published_iso8601)."' pubdate>".$row->published."</time></i> | filter: ".$blogFilter."</p>
                    </header>".
                    $filteradContent
                ."</section><hr />";
}

?>
<div class="page">
    <div class="container">
        <div class="row">
            <h2>BLOGG</h2>
            <a href=<?= $app->url->create('createblogpost') ?>>Lägg till blogginlägg</a>
        </div>
        <div class="pillow-20">

        </div>
        <?= $bloggs ?>
    </div>

</div>
