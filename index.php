<?php

use AltoRouter as Router;
use Saladin\AccessManager;
use Saladin\SqlGenerator;


require_once __DIR__ . "/vendor/autoload.php";

$router = new Router();
$router->setBasePath('/gen');

$router->map("GET", "/login", function () {
    $cmd = new AccessManager();
    $cmd->login();
});
$router->map("GET", "/logout", function () {
    $cmd = new AccessManager();
    $cmd->logout();
});


$router->map("GET|POST", "/", function () {
    $gen = new SqlGenerator();
    $gen->index();
});

$router->map("POST", "/databases", function () {
    $gen = new SqlGenerator();
    $gen->dblist();
});
$router->map("POST", "/tables", function () {
    $gen = new SqlGenerator();
    $gen->tablelist();
});
$router->map("POST", "/columns", function () {
    $gen = new SqlGenerator();
    $gen->columnlist();
});
$router->map("POST", "/process", function () {
    $gen = new SqlGenerator();
    $gen->process();
});
$router->map("POST", "/run", function () {
    $gen = new SqlGenerator();
    $gen->run();
 });
 



$match = $router->match();
if (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    echo "ไม่พบหน้าที่ต้องการ\n";
}
