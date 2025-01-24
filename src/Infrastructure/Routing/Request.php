<?php

namespace App\Infrastructure\Routing;

class Request {
    private string $method;
    private string $path;
    private array $queryParams;
    private array $bodyParams;
    private array $jsonBodyParams;


    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/', '/'); 
        $this->queryParams = $_GET ?? [];
        $this->bodyParams = $_POST ?? [];
        $this->jsonBodyParams = $this->parseJsonBody();
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function getPath(): string {
        return $this->path;
    }

    public function getQueryParams(): array {
        return $this->queryParams;
    }

    public function getBodyParams(): array {
        return $this->bodyParams;
    }

    public function getJsonBodyParams(): array {
        return $this->jsonBodyParams;
    }

    public function getParam(string $key, $default = null) {
        return $this->queryParams[$key] 
            ?? $this->bodyParams[$key] 
            ?? $this->jsonBodyParams[$key] 
            ?? $default;
    }

    private function parseJsonBody(): array {
        if ($this->method === 'POST' && empty($this->bodyParams)) {
            $rawInput = file_get_contents('php://input');
            $decoded = json_decode($rawInput, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }
}
