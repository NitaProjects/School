<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!empty($_SESSION['message'])): ?>
    <script>
        alert("<?= htmlspecialchars($_SESSION['message']) ?>");
    </script>
<?php
    unset($_SESSION['message'], $_SESSION['message_type']);
endif;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>San Daniel</title>
    <link rel="stylesheet" href="/public/css/home.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>San Daniel</h1>
            <nav>
                <ul class="nav-links">
                    <li><a href="/assign-teacher">Asignar Profesor</a></li>
                    <li><a href="/enroll-student">Matricular Estudiante</a></li>
                </ul>
            </nav>
        </div>
    </header>

    

    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> San Daniel. Todos los derechos reservados.</p>
            <p>Contacto: <a href="mailto:soporte@sandaniel.com">Daniel es un crack</a></p>
        </div>
    </footer>
</body>
</html>
