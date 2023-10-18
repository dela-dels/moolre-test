<?php

class HttpHandler
{
    public function handleRequest()
    {
        // Get the request method.
        $method = $_SERVER['REQUEST_METHOD'];

        // Get the request path.
        $path = $_SERVER['REQUEST_URI'];

        // Split the request path into segments.
        $pathSegments = explode('/', $path);

        // Get the controller name.
        $controllerName = $pathSegments[1];

        // Get the action name.
        $actionName = $pathSegments[2];

        // Load the controller class.
        $controllerClass = 'Src\\Controllers\\' . $controllerName . 'Controller';

        // Create a new instance of the controller class.
        $controller = new $controllerClass();

        // Call the action method on the controller.
        $response = $controller->{$actionName}();

        // Return the response.
        return $response;
    }
}

// Create a new HTTP handler object.
$httpHandler = new HttpHandler();

// Handle the incoming request.
$response = $httpHandler->handleRequest();

// Send the response to the client.
header('Content-Type: application/json');
echo json_encode($response);
