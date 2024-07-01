<?php
require_once COOR.'route.php';
require_once COOR.'Controller.php';
require_once COOR.'database.php';

$router = new Router();

// Routes GET
$router->get('/', 'LoginController@index');
$router->get('/product', 'ProductController@index');
$router->get("/dette", "DetteController@index");
$router->get("/home", "HomeController@index");

// Routes POST

// Route POST pour le formulaire de connexion
$router->post('/', 'AuthController@login');


// Dispatch des routes en fonction de l'URI actuelle
$router->dispatch($_SERVER['REQUEST_URI']);
// var_dump($router);
?>
