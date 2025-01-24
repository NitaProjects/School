<?php

/**
 * Función para depurar: Muestra las variables y detiene la ejecución.
 */
function dd() {
    foreach (func_get_args() as $arg) {
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
    die;
}

/**
 * Renderiza una plantilla de vista con datos opcionales.
 */
function view(string $template, array $data = null): string {
    if ($data) {
        extract($data, EXTR_OVERWRITE);
    }
    ob_start();
    require VIEWS . '/' . $template . '.view.php'; 
    return ob_get_clean();
}

/**
 * Redirige a una URL específica y detiene la ejecución.
 */
function redirect(string $url): void {
    header("Location: $url");
    exit;
}

/**
 * Maneja mensajes flash en la sesión: guarda o recupera y elimina un mensaje.
 */
function session_flash(string $key, ?string $value = null): ?string {
    if ($value === null) {
        $message = $_SESSION[$key] ?? null;
        unset($_SESSION[$key]);
        return $message;
    }
    $_SESSION[$key] = $value;
    return null;
}

/**
 * Genera una URL absoluta para recursos como CSS, JS o imágenes.
 */
function asset(string $path): string {
    return "/public/$path";
}

/**
 * Limpia una cadena para evitar ataques XSS.
 */
function sanitize(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
