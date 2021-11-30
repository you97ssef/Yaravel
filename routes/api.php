<?php

use app\Controllers\DefaultController;

// API Routes
$router->api(null, DefaultController::class);
$router->api("/", DefaultController::class);
