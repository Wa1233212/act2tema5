<?php

$request = $_SERVER['REQUEST_URI'];

$allowed_routes = [
    '/' => 'inicio.php',
    '/home' => 'home.php',
    '/login' => 'login.php',
    '/register' => 'create.php',
    '/logeo' => 'logeo.php',
    '/carrito' => 'carrito.php'
];

if (array_key_exists($request, $allowed_routes)) {
    require $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '../resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $allowed_routes[$request];
} else {
    http_response_code(404);
    require $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '../resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . '404.php';
}