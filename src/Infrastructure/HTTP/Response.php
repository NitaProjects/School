<?php

namespace App\Infrastructure\HTTP;

class Response {
    private int $statusCode;  // Código de estado HTTP
    private mixed $body;      // Cuerpo de la respuesta
    private array $headers;   // Encabezados HTTP

    /**
     * Constructor de la clase Response.
     *
     * @param mixed $body Contenido del cuerpo de la respuesta.
     * @param int $statusCode Código de estado HTTP.
     * @param array $headers Encabezados HTTP adicionales.
     */
    public function __construct(mixed $body = null, int $statusCode = 200, array $headers = []) {
        $this->statusCode = $statusCode;
        $this->body = $body ?? '';
        $this->headers = array_merge([
            'X-Powered-By' => 'PHP App'
        ], $headers);
    }

    /**
     * Crea una respuesta en formato JSON.
     *
     * @param array $data Datos a codificar como JSON.
     * @param int $statusCode Código de estado HTTP.
     * @return self
     */
    public static function json(array $data, int $statusCode = 200): self {
        $json = json_encode($data);

        if ($json === false) {
            // Manejo de errores de JSON
            return new self(json_encode(['error' => 'Failed to encode JSON']), 500, ['Content-Type' => 'application/json']);
        }

        return new self($json, $statusCode, ['Content-Type' => 'application/json']);
    }

    /**
     * Crea una respuesta en formato HTML.
     *
     * @param string $view Nombre de la vista a cargar (sin extensión .php).
     * @param array $data Variables a pasar a la vista.
     * @param int $statusCode Código de estado HTTP.
     * @return self
     */
    public static function html(string $view, array $data = [], int $statusCode = 200): self {
        $viewFile = VIEWS . "/{$view}.view.php";

        if (!file_exists($viewFile)) {
            // Retorna un error si la vista no existe
            return new self("<h1>View not found: {$view}</h1>", 404, ['Content-Type' => 'text/html']);
        }

        ob_start();
        extract($data); // Extrae variables para usarlas en la vista
        include $viewFile;
        $body = ob_get_clean();

        return new self($body, $statusCode, ['Content-Type' => 'text/html']);
    }

    /**
     * Crea una redirección HTTP.
     *
     * @param string $url URL a redirigir.
     * @param int $statusCode Código de estado HTTP (por defecto 302).
     * @return self
     */
    public static function redirect(string $url, int $statusCode = 302): self {
        return new self(null, $statusCode, ['Location' => $url]);
    }

    /**
     * Envía la respuesta HTTP al cliente.
     */
    public function send(): void {
        // Establece el código de estado HTTP
        http_response_code($this->statusCode);

        // Envía los encabezados HTTP
        foreach ($this->headers as $key => $value) {
            header("{$key}: {$value}");
        }

        // Envía el cuerpo de la respuesta (si lo hay)
        if (!empty($this->body)) {
            echo $this->body;
        }
    }
}