<?php

$blockdata = "";
if ($blockslug != '') {
    $app->database->connect();
    $sql = "SELECT data FROM content WHERE slug = ?";
    if ($res = $app->database->executeFetchAll($sql, [$blockslug])) {
        foreach ($res as $row) {
            $blockdata = $row->data;
        }
    }
}
echo $blockdata;
