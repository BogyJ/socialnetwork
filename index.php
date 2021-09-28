<?php
    require_once 'Configuration.php';
    require_once 'vendor/autoload.php';

    session_start();
    if (!isset($_SESSION["loggedIn"])) {
        $_SESSION["loggedIn"] = false;
        $_SESSION["userId"] = null;
        $_SESSION["login-recorded"] = false;
    }

    $databaseConfiguration = new \App\Core\DatabaseConfiguration(Configuration::DATABASE_HOST, Configuration::DATABASE_USER, Configuration::DATABASE_PASSWORD, Configuration::DATABASE_NAME);
    $databaseConnection = new \App\Core\DatabaseConnection($databaseConfiguration);

    $url = strval(filter_input(INPUT_GET, 'URL'));
    $httpMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
    $ipAddress = filter_input(INPUT_SERVER, "REMOTE_ADDR");
    $_SESSION["ip-address"] = $ipAddress;

    $router = new \App\Core\Router();
    $routes = require_once 'Routes.php';
    foreach ($routes as $route) {
        $router->add($route);
    }
    $route = $router->find($httpMethod, $url);
    $arguments = $route->extractArguments($url);

    $fullControllerName = "\\App\\Controllers\\" . $route->getControllerName() . "Controller";
    $controller = new $fullControllerName($databaseConnection);
    $controller->__pre();
    call_user_func_array([$controller, $route->getControllerFunction()], $arguments);
    $data = $controller->getData();

    foreach ($data as $name => $value) {
        $$name = $value;
    }

    $loader = new \Twig\Loader\FilesystemLoader('./views');
    $twig = new \Twig\Environment($loader, [
        'cache' => './twig-cache',
        'auto_reload' => true // set false to enable caching
    ]);

    $data["BASE"] = Configuration::BASE;

    echo $twig->render($route->getControllerName() . '/' . $route->getControllerFunction() . '.html', $data);
