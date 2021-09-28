<?php
    namespace App\Core;

    final class Router {
        private $routes = [];

        public function __construct() { }

        public function add(\App\Core\Route $route) {
            $this->routes[] = $route;
        }

        public function &find(string $method, string $url) {
            foreach ($this->routes as $route) {
                if ($route->matches($method, $url)) {
                    return $route;
                }
            }

            return NULL;
        }

    }
