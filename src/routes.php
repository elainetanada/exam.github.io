<?php
// Set Controller and Method base on the url.
$controllerName = 'Product';  // default controller name
$methodName = 'index'; // default method name


// Build controller name if request has URI
if(isset($_SERVER['REQUEST_URI'])) {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $segments = explode('/', $uri);
    if(isset($segments[1]) && $segments[1]) {
        $controllerName = $segments[1];
    }
    if(isset($segments[2]) && $segments[2]) {
        $methodName = $segments[2];
    }
    $params = [];
    
    if(count($segments) > 3) {
        foreach($segments as $key => $segment) {
            if($key > 2) {
                $params[] = $segment;
            }
        }
    }
}

$controllerClassName = ucfirst($controllerName) . 'Controller'; // build the controller name string


if (!file_exists(__DIR__ .'/Controller/' . $controllerClassName . '.php')) {
    echo 'Controller not found!'; // Display error if controller does not exist
    exit();
}

require __DIR__ . '/Controller/' . $controllerClassName . '.php';

$repositoryClassName = ucfirst($controllerName) . 'Repository'; // build the repository name string

if (!file_exists(__DIR__ .'/Repositories/' . $repositoryClassName . '.php')) {
    echo 'Repository not found!'; // Display error if Repository does not exist
    exit();
}

require __DIR__ . '/Repositories/' . $repositoryClassName . '.php';

$class = '\App\Controller\\'.$controllerClassName;
$repository = '\App\Repositories\\'.$repositoryClassName;

$controller = new $class(new $repository); // Using Dependency Inversion from SOLID principle
if (!method_exists($controller, $methodName)) {
    echo "Method not found!"; // Display error if Method does not exist
    exit();
} 

if($params) {
    $controller->$methodName($params);
} else {
    $controller->$methodName();
}
