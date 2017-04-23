<?php
$previewcontent = "";
if (isset($_POST['blogpreview'])) {
    $textfilter = new Maaa16\Textfilter\Textfilter();
    $content = new \Maaa16\Content\Content();
    $blogfilter = $content->getFilters(isset($_POST['markdown']), isset($_POST['bbcode']), isset($_POST['link']), isset($_POST['nl2br']));
    if (isset($_POST['markdown'])) {
        $app->session->set('markdowncheck', 'checked');
    } else {
        $app->session->delete('markdowncheck');
    }
    if (isset($_POST['bbcode'])) {
        $app->session->set('bbcodecheck', 'checked');
    } else {
        $app->session->delete('bbcodecheck');
    }
    if (isset($_POST['link'])) {
        $app->session->set('linkcheck', 'checked');
    } else {
        $app->session->delete('linkcheck');
    }
    if (isset($_POST['nl2br'])) {
        $app->session->set('nl2brcheck', 'checked');
    } else {
        $app->session->delete('nl2brcheck');
    }

    if (isset($_POST['blogContent'])) {
        $app->session->set('blogContent', $_POST['blogContent']);
    } else {
        $app->session->delete('blogContent');
    }

    if (isset($_POST['blogtitle'])) {
        $app->session->set('blogtitle', $_POST['blogtitle']);
    } else {
        $app->session->delete('blogtitle');
    }


    if ($app->session->get('blogContent', '') != '' || $app->session->get('blogtitle', '') != '') {
        $previewcontent =   "<div class='previewdiv'>
                                <p class='text-muted'>Förhandsgranskning | Filter: ".$blogfilter."</p>
                                <br />
                                <h1>".htmlentities($_POST['blogtitle'])."</h1>".
                                    $textfilter->doFilter($_POST['blogContent'], $blogfilter)
                            ."</div>";
    }
} else if (isset($_POST['blogcreate']) && isset($_POST["blogtitle"])) {
    $app->database->connect();
    $sql = "INSERT INTO content (title) VALUES (?);";
    $app->database->execute($sql, [$_POST["blogtitle"]]);
    $id = $app->database->lastInsertId();


    $content = new \Maaa16\Content\Content();
    $blogslug = $content->slugify($_POST["blogtitle"]);
    $sluglength = strlen($blogslug);
    $blogslug = $content->makeSlugUnique($app, $sluglength, $blogslug);
    $path = $content->checkPath($app, $path, $id);
    $blogfilter = $content->getFilters(isset($_POST['markdown']), isset($_POST['bbcode']), isset($_POST['link']), isset($_POST['nl2br']));
    $params = [
            $_POST['blogtitle'],
            $path,
            $blogslug,
            $_POST["blogContent"],
            'post',
            $blogfilter,
            'Published',
            $id
        ];
        $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, status=?, published = NOW(), updated = NOW() WHERE id = ?";
        $app->database->execute($sql, $params);
        header('Location: blog');
}


?>
<div class="page">
    <div class="container">
        <div class="row">
            <a href=<?= $app->url->create('blog') ?>>Tillbaka</a>
            <h2>Skapa blogginlägg</h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="#" method="POST">
                    <div class="form-group">
                        <label for="blogtitle">TITEL</label>
                        <input class="form-control" type="text" name="blogtitle" value="<?= $app->session->get('blogtitle', '') ?>">
                    </div>
                    <div class='form-group'>
                        <label>BLOGGINLÄGG</label>
                        <textarea class='form-control' name='blogContent'><?= $app->session->get('blogContent', '') ?></textarea>
                    </div>
                    <div class="form-group">
                        <p class="text-muted">Välj en eller flera filter för att blogginlägget.</p>
                        <span><b>FILTER:</b>&nbsp;</span>
                        <label class='text-muted' for='markdown'><a href="https://en.wikipedia.org/wiki/Markdown">markdown</a></label>
                        <input type="checkbox" name="markdown" value="markdown" <?= ($app->session->get('markdowncheck') == 'checked') ? 'checked' : '' ?>> |
                        <label class='text-muted' for='bbcode'><a href="https://sv.wikipedia.org/wiki/BBCode">bbcode</a></label>
                        <input type="checkbox" name="bbcode" value="bbcode" <?= ($app->session->get('bbcodecheck') == 'checked') ? 'checked' : '' ?>> |
                        <label class='text-muted' for='markdown'>link <small>(gör http://länk klickbara)</small></label>
                        <input type="checkbox" name="link" value="link" <?= ($app->session->get('linkcheck') == 'checked') ? 'checked' : '' ?>> |
                        <label class='text-muted' for='markdown'>nl2br <small>(fixar ny rad i texten)</small></label>
                        <input type="checkbox" name="nl2br" value="nl2br" <?= ($app->session->get('nl2brcheck') == 'checked') ? 'checked' : '' ?>>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="blogcreate" value="Skapa">
                        <input class="btn btn-default" type="submit" name="blogpreview" value="Förhandsgranska">
                        <input class="btn btn-default" type="submit" name="blogcancel" value="Ångra">
                    </div>
                </form>
            </div>
        </div>
        <!-- /row -->

        <?= $previewcontent ?>
    </div>
</div>
