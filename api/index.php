<?php

set_time_limit(0);

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: *');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Logger;
use App\TrainService;

$path    = __DIR__ . '/log';
$logger  = new Logger($path);

$route = 'train-list';
if(!empty($_SERVER['PATH_INFO']))
   $route = trim($_SERVER['PATH_INFO'], '/');

$routes = [
    'train-route' => 'getTrainRoute',
    'cities'      => 'getCities',
    'train-list'  => 'getTrainList',
];

if(empty($routes[$route])) {
    getResponse(['error' => 'Не найден запрошенный маршрут']);
}

$action = $routes[$route];

$auth = [
    'login' => 'test',
    'psw' => 'bYKoDO2it',
    'terminal' => 'htk_test',
    'represent_id' => 22400,
];

$trainService = new TrainService($auth);

try {
    $results = $trainService->$action();
} catch (\SoapFault $err) {

    $errorMessage = $err->getMessage();
    $error = ['error' => $errorMessage];

    $title = 'Error Logger';
    $logger->log($error, $title);

    getResponse($error);
}

getResponse((array)$results);

/////////////////////////////
/////////////////////////////
///  --- Helpers ----
function getResponse($data, $fname = '') {
    if($fname) $results[$fname] = $data;
    else   $results = $data;
    die(json_encode($results));
}

function lg($data) {
    $r = print_r($data, true);
    print '<pre>' .$r . '</pre>';
    die;
}






