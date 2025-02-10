<?php

$routes = require('routes.php');

// Function to route the URI to the correct controller
function routeToController($uri, $routes){
    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        abort(); // This is still valid because `abort()` is now defined in index.php
    }
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

routeToController($uri, $routes);
