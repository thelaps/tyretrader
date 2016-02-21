<?php
session_start();
error_reporting(E_ALL);
$ts = microtime(true);

define('CORE_WEB_DIR', __DIR__.DIRECTORY_SEPARATOR);
require 'core/app.php';

App::start();


$te = microtime(true);
$time = ($te - $ts);
//print_r($time);
?>
