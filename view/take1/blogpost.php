<?php
$bloggpost = "";
if (isset($_GET['blogslug'])) {
    $slug = htmlentities($_GET['blogslug']);
    $app->database->connect();
    $sql = "SELECT
                *,
                DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
                DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
        FROM content WHERE type = ? AND slug = ?";
    if ($res = $app->database->executeFetchAll($sql, ['post', $slug])) {
        $textfilter = new Maaa16\Textfilter\Textfilter();
        foreach ($res as $row) {
            $blogContent = $row->data;
            $blogFilter = $row->filter;
            $filteradContent = $textfilter->doFilter($blogContent, $blogFilter);
            $bloggpost .= "<section>
                            <header>
                                <h1>".$row->title."</h1>
                                <p><i>Senast uppdaterad: <time datetime='".htmlentities($row->published_iso8601)."' pubdate>".$row->published."</time></i> | filter: ".$blogFilter."</p>
                            </header>".
                            $filteradContent
                        ."</section>";
        }
    }
}
?>

<div class="page">
    <div class="container">
        <a href=<?= $app->url->create('blog') ?>>Tillbaka</a>
        <div class="pillow-20">

        </div>
        <?= $bloggpost ?>
    </div>

</div>
