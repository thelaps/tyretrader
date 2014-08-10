<?php
session_start();
error_reporting(E_ALL);
$ts = microtime(true);


require 'core/app.php';

App::start();


$te = microtime(true);
$time = ($te - $ts);
//print_r($time);
?>
