<?php

require '../vendor/autoload.php';

use Service\RouteService;
use Service\ApplicationService;

$route = new RouteService();
$app   = new ApplicationService($route);

$app->run();
