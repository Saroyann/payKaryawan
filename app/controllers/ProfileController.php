<?php
function render($contentFile) {
    $content = $contentFile;
    include __DIR__ . '/../views/MainPages.php';
}

render(__DIR__ . '/../views/pages/Profile.php');