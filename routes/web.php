<?php

//App routes

use app\Controllers\DefaultController;

$router->addRoute(null, DefaultController::class, "viewDefault");
$router->addRoute("/", DefaultController::class, "viewDefault");
