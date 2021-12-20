<?php

// Class loader -----------------------------------------------------
require_once "framework/utils/ClassLoader.php";
$loader = new framework\utils\ClassLoader('.');
$loader->register();
// ------------------------------------------------------------------


// Uses -------------------------------------------------------------
use framework\http\HttpRequest;
use framework\utils\Router;
use framework\utils\ConnectionFactory;
use framework\View;
// ------------------------------------------------------------------


//Http Requests -----------------------------------------------------
$request = new HttpRequest();
// ------------------------------------------------------------------


// Style ------------------------------------------------------------
View::addStyleSheet("/html/css/bootstrap.min.css");
View::addStyleSheet("/html/css/style.css");
// ------------------------------------------------------------------


// Script -----------------------------------------------------------
View::addScript("/html/js/script.js");
// ------------------------------------------------------------------


// Database ---------------------------------------------------------
$keys = parse_ini_file("config/config.ini");
ConnectionFactory::makeConnection($keys, dirname(__FILE__));
// ------------------------------------------------------------------


//App Run -----------------------------------------------------------
$router = new Router($request);
require_once "routes/api.php";
require_once "routes/web.php";
$router->run();
// ------------------------------------------------------------------