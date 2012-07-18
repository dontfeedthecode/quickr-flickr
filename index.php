<?php
/**
 * Custom PHP framework for Yahoo Test
 * =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
 * Note: We will forgo autoloading, routing and other niceties as we know
 * that there will only be one controller being used in this test
 * and have limited time to complete.
 * 
 * Tim Sheehan
 * 
 */
session_start();
require_once('libs/Twig/Autoloader.php');
require_once('libs/flickr.php'); // Custom written Flickr lib
require_once('libs/pagination.php');
require_once('controller/controller.php');
require_once('controller/main.php');
require_once('model/model.php');
require_once('model/photo.php');

// Manually set up main controller
$main = new Controller_Main();

// Split routes
$route = ($_GET['route']) ? explode('/', $_GET['route']) : array();

// More assumptions that these methods will always exist
switch(count($route))
{
	// Assume method name only
	case 1:
		$main->{$route[0]}();
		break;
	// Assume method and parameter
	case 2:
		$main->{$route[0]}($route[1]);
		break;
	// Send everything else to index page
	default:
		$main->index();
	break;
}