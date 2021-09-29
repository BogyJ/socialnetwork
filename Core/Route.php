<?php
    namespace App\Core;

    final class Route {
        private $requestMethod;
        private $pattern;
        private $controllerName;
        private $controllerFunction;

        public function __construct(string $requestMethod, string $pattern, string $controllerName, string $controllerFunction) {
            $this->requestMethod = $requestMethod;
            $this->pattern = $pattern;
            $this->controllerName = $controllerName;
            $this->controllerFunction = $controllerFunction;
        }

        public static function get(string $pattern, string $controllerName, string $controllerFunction): Route {
            return new Route('GET', $pattern, $controllerName, $controllerFunction);
        }

        public static function post(string $pattern, string $controllerName, string $controllerFunction): Route {
            return new Route('POST', $pattern, $controllerName, $controllerFunction);
        }

        public static function any(string $pattern, string $controllerName, string $controllerFunction): Route {
            return new Route('GET|POST', $pattern, $controllerName, $controllerFunction);
        }

        public function getControllerName(): string {
            return $this->controllerName;
        }

        public function getControllerFunction(): string {
            return $this->controllerFunction;
        }

        public function matches(string $method, string $url) {
            if (!preg_match('/^' . $this->requestMethod . '$/', $method)) {
                return false;
            }

            return preg_match($this->pattern, $url);
        }

        public function &extractArguments(string $url): array {
            $matches = [];
            $arguments = [];

            preg_match_all($this->pattern, $url, $matches);
            if (isset($matches[1])) {
                $arguments = $matches[1];
            }

            return $arguments;
        }

    }
