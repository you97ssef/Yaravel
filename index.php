<?php

// Class loader -----------------------------------------------
require_once "framework/utils/ClassLoader.php";
$loader = new framework\utils\ClassLoader('.');
$loader->register();
// ------------------------------------------------------------


// Uses -------------------------------------------------------
use framework\http\HttpRequest;
use framework\utils\Router;
use framework\utils\ConnectionFactory;
use framework\View;
// ------------------------------------------------------------


//Http Requests -----------------------------------------------
$http = new HttpRequest();
// ------------------------------------------------------------


// Style ------------------------------------------------------
View::addStyleSheet("/html/css/bootstrap.min.css");
View::addStyleSheet("/html/css/style.css");
// ------------------------------------------------------------


// Script -----------------------------------------------------
View::addScript("/html/js/script.js");
// ------------------------------------------------------------


// Database ---------------------------------------------------
$keys = parse_ini_file("conf/config.ini");
ConnectionFactory::makeConnection($keys);
// ------------------------------------------------------------


//App Run -----------------------------------------------------
$router = new Router($http);
require_once "routes/api.php";
require_once "routes/web.php";
$router->run();
// ------------------------------------------------------------