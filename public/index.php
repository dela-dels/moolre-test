<?php


use MoolrePayments\Core\Http\Router;

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . 'functions.php';
require BASE_PATH . 'vendor/autoload.php';
require BASE_PATH . 'bootstrap.php';

header("Content-Type: application/json;charset=utf-8");
header("Accept: application/json");

$router = new Router();
$routes = require BASE_PATH . 'routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = isset($_POST['_method']) ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);


