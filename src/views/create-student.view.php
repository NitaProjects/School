<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Estudiante</title>
    <link rel="stylesheet" href="/public/css/formularios.css">
</head>

<body>
    <!-- Encabezado -->
    <header class="header">
        <div class="container">
            <h1>Sistema de Gestión Escolar</h1>
            <nav>
                <ul>
                    <li><a href="/">🏠 Inicio</a></li>
                    <li><a href="/enroll-student">➕📝 Matricular Estudiante</a></li>

                </ul>
            </nav>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="main">
        <div class="container">
            <h2>Crear Estudiante</h2>

            <!-- Mensaje de Alerta -->
            <!-- Mensaje de Alerta -->
            <?php if ($message = session_flash('message')): ?>
                <div class="alert <?= session_flash('message_type') === 'error' ? 'alert-error' : 'alert-success' ?>">
                    <?= sanitize($message) ?>
                </div>
            <?php endif; ?>



            <!-- Formulario -->
            <form action="/store-student" method="POST" class="form">
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="enrollment_date">Fecha de Matrícula:</label>
                    <input type="date" id="enrollment_date" name="enrollment_date" required>
                </div>

                <button type="submit" class="btn-primary">Crear</button>
            </form>

            <p>
                <a href="/enroll-student" class="btn-back">← Volver a la Lista de Estudiantes</a>
            </p>
        </div>
    </main>

    <!-- Pie de Página -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> San Daniel. Todos los derechos reservados.</p>
            <p>Contacto: <a href="mailto:soporte@sandaniel.com">Daniel es un crack</a></p>
        </div>
    </footer>
</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('enrollment_date').value = today;
    });
</script>

</html>