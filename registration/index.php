<?php

// Include the routes array (make sure the path to routes.php is correct)
$routes = require('routes.php');

// Function to handle errors (e.g., 404)
function abort($code = 404) {
    http_response_code($code);
    require "views/{$code}.php";  // Make sure views like 404.php exist
    die(); // Terminate the script
}

// Function to route the URI to the correct controller
function routeToController($uri, $routes) {
    if (array_key_exists($uri, $routes)) {
        // Include the corresponding controller file
        require $routes[$uri];
    } else {
        // If the route does not exist, show a 404 error
        abort();
    }
}

// Get the URI path (remove query parameters if any)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Call the routing function to direct the request to the appropriate controller
routeToController($uri, $routes);
