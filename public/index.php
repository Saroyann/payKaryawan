<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$request = $_SERVER['REQUEST_URI'];

require __DIR__ . '/../app/routes/Web.php';