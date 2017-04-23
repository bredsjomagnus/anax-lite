<?php
?>
<div class="page">
    <div class="container">
        <div class="row">
            <h1>BLOCKTEST</h1>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $app->block->getBlock('lista'); ?>
            </div>
            <div class="col-md-6">
                <?= $app->block->getBlock('info'); ?>
                <?= $app->block->getBlock('progbild'); ?>
            </div>
        </div>
    </div>

</div>
