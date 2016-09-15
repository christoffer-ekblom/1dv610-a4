<?php

session_start();

if(!$_SESSION['isLoggedIn']) {
	$_SESSION['isLoggedIn'] = false;
}

require_once('controller/MasterController.php');

$controller = new \controller\MasterController();
$controller->init();