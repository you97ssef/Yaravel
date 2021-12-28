<?php

use app\Controllers\DefaultController;

// API Routes
$router->api("", DefaultController::class);
$router->api("/", DefaultController::class);
