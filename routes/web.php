<?php

//App routes

use app\Controllers\DefaultController;

$router->addRoute("", DefaultController::class, "viewDefault");
$router->addRoute("/", DefaultController::class, "viewDefault");
$router->addRoute("/AddName", DefaultController::class, "addName");