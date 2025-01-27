<?php

namespace App\Infrastructure\HTTP;

class Response
{
    private int $statusCode;
    private mixed $body;
    private array $headers;

    public function __construct(mixed $body = null, int $statusCode = 200, array $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->body = $body ?? '';
        $this->headers = array_merge([
            'X-Powered-By' => 'PHP App'
        ], $headers);
    }

    public static function json(array $data, int $statusCode = 200): self
    {
        $json = json_encode($data);

        if ($json === false) {
            // Manejo de errores de JSON
            return new self(json_encode(['error' => 'Failed to encode JSON']), 500, ['Content-Type' => 'application/json']);
        }

        return new self($json, $statusCode, ['Content-Type' => 'application/json']);
    }

    public static function html(string $view, array $data = [], int $statusCode = 200): self
    {
        $viewFile = VIEWS . "/{$view}.view.php";

        if (!file_exists($viewFile)) {
            return new self("<h1>View not found: {$view}</h1>", 404, ['Content-Type' => 'text/html']);
        }

        ob_start();
        extract($data); // Extrae variables para usarlas en la vista
        include $viewFile;
        $body = ob_get_clean();

        return new self($body, $statusCode, ['Content-Type' => 'text/html']);
    }

    public static function redirect(string $url, int $statusCode = 302): self
    {
        return new self(null, $statusCode, ['Location' => $url]);
    }

    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $key => $value) {
            header("{$key}: {$value}");
        }

        if (!empty($this->body)) {
            echo $this->body;
        }
    }
}
