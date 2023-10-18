<?php

global $router;

use MoolrePayments\Http\Controllers\InitialisePaymentController;

$router->post('/transactions/initialise', InitialisePaymentController::class);