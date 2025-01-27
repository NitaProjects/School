<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Departamento</title>
    <link rel="stylesheet" href="/public/css/create.css">
</head>

<body>
    <!-- Encabezado -->
    <header class="header">
        <div class="container">
            <h1>Crear Departamento</h1>
            <nav>
                <ul class="nav-links">
                    <!-- Enlace directo a Inicio -->
                    <li><a href="/">🏠 Inicio</a></li>

                    <!-- Menú desplegable para Profesores -->
                    <li>
                        <a href="#">📚 Profesores</a>
                        <ul class="dropdown">
                            <li><a href="/create-teacher">➕ Crear Profesor</a></li>
                            <li><a href="/delete-teacher">❌ Eliminar Profesor</a></li>
                        </ul>
                    </li>

                    <!-- Menú desplegable para Departamentos -->
                    <li>
                        <a href="#">🏢 Departamentos</a>
                        <ul class="dropdown">
                            <li><a href="/update-department">✏️ Editar Departamento</a></li>
                            <li><a href="/delete-department">❌ Eliminar Departamento</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="main">
        <div class="container">
            <h2></h2>

            <!-- Mensaje de Alerta -->
            <?php if ($message = session_flash('message')): ?>
                <div class="alert <?= session_flash('message_type') === 'error' ? 'alert-error' : 'alert-success' ?>">
                    <?= sanitize($message) ?>
                </div>
            <?php endif; ?>

            <!-- Formulario -->
            <form action="/store-department" method="POST" class="form">
                <div class="form-group">
                    <label for="name">Nombre del Departamento:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="description">Descripción:</label>
                    <textarea id="description" name="description" rows="3" required></textarea>
                </div>

                <button type="submit" class="btn-primary">Crear</button>
            </form>

            <p>
                <a href="/assign-teacher" class="btn-back">← Volver a Asignar Profesor</a>
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

</html>