<?php
//entry script

require_once "../vendor/autoload.php";

use app\Router;
use app\controllers\ProductController as ProductContr;


$router = new Router();
$prodContr = new ProductContr();


$router->get('/', [$prodContr, 'index']);
$router->get('/products', [ProductContr::class, 'index']);
$router->get('/products/create', [ProductContr::class, 'create']);
$router->get('/products/update', [ProductContr::class, 'update']);

$router->post('/products/create', [ProductContr::class, 'create']);
$router->post('/products/update', [ProductContr::class, 'update']);
$router->post('/products/delete', [ProductContr::class, 'delete']);

$router->resolve();//detect the route and call the coresponding function

?>