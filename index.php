<?php

// Class loader -----------------------------------------------
require_once "framework/utils/ClassLoader.php";
$loader = new framework\utils\ClassLoader('.');
$loader->register();
// ------------------------------------------------------------


// usables ----------------------------------------------------
use framework\http\HttpRequest;
use framework\utils\Router;
use framework\View;

// ------------------------------------------------------------


//Http Requests -----------------------------------------------
$http = new HttpRequest();
// ------------------------------------------------------------


// Style ------------------------------------------------------
View::addStyleSheet("/html/css/bootstrap.min.css");
View::addStyleSheet("/html/css/style.css");
// ------------------------------------------------------------


//App Run -----------------------------------------------------
$router = new Router($http);
require_once "routes/api.php";
require_once "routes/web.php";
$router->run();
echo $router->urlFor("/fee", ["id"=>"1", "data"=>"data"]);
// ------------------------------------------------------------