<?php

namespace App\Infrastructure\Routing;

use App\Infrastructure\HTTP\Response;

class Router
{
    private array $routes = [];

    public function addRoute(string $method, string $path, callable|array $action): self
    {
        $this->routes[strtoupper($method)][] = [
            'path' => $this->normalizePath($path),
            'action' => $action,
        ];
        return $this;
    }

    public function dispatch(Request $request): void
    {
        $method = strtoupper($request->getMethod());
        $path = $this->normalizePath($request->getPath());

        foreach ($this->routes[$method] ?? [] as $route) {
            $params = $this->match($route['path'], $path);

            if ($params !== null) {
                try {
                    $result = call_user_func($route['action'], $request, $params);

                    if ($result instanceof Response) {
                        $result->send();
                    } else {
                        echo $result;
                    }
                    return;
                } catch (\Exception $e) {
                    Response::json(['error' => $e->getMessage()], 500)->send();
                    return;
                }
            }
        }

        Response::json(['error' => 'Route not found'], 404)->send();
    }

    private function normalizePath(string $path): string
    {
        return trim($path, '/');
    }

    private function match(string $routePath, string $requestPath): ?array
    {
        $routeParts = explode('/', $routePath);
        $requestParts = explode('/', $requestPath);

        if (count($routeParts) !== count($requestParts)) {
            return null;
        }

        $params = [];
        foreach ($routeParts as $index => $part) {
            if (preg_match('/^\{(\w+)\}$/', $part, $matches)) {
                $params[$matches[1]] = $requestParts[$index];
            } elseif ($part !== $requestParts[$index]) {
                return null;
            }
        }

        return $params;
    }
}
