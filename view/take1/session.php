<?php
// $session = new Maaa16\Session\Session();
// $session->start();
$app->session = new Maaa16\Session\Session();
$app->session->start();
if (!$app->session->has('number')) {
    $app->session->set('number', 10);
    $message = "<h3> &#36;_SESSION['number'] = 10</h3>";
    $message .= "<i>Initierar &#36;key 'number' och sätter den till 10</i>";
} else {
    $message = "<h3> &#36;_SESSION['number'] = " . $app->session->get('number') ." </h3>";
    // $message .= "<p>" . $session->get('number') . "</p>";
}

?>
<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary" href=<?= $app->url->create("session/increment") ?>>/increment</a>
                <a class="btn btn-primary" href=<?= $app->url->create("session/decrement") ?>>/decrement</a>
                <a class="btn btn-primary" href=<?= $app->url->create("session/status") ?>>/status</a>
                <a class="btn btn-primary" href=<?= $app->url->create("session/dump") ?>>/dump</a>
                <a class="btn btn-primary" href=<?= $app->url->create("session/destroy") ?>>/destroy</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $message; ?>
            </div>
        </div>

    </div>
</div>
