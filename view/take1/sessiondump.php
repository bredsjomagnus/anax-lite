<?php

// $session = new Maaa16\Session\Session();
// $session->start();
?>

<div class="page">
    <div class="container">
        <h2>Session Dump</h2>
            <?php $app->session->dump();?>
            <p><a href=<?= $app->url->create('session')?>>Tillbaka</a></p>
    </div>
</div>
