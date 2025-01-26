<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso</title>
    <link rel="stylesheet" href="/public/css/create.css">
</head>

<body>
    <!-- Encabezado -->
    <header class="header">
        <div class="container">
            <h1>Crear Curso</h1>
            <nav>
                <ul class="nav-links">
                    <!-- Enlace directo a Inicio -->
                    <li><a href="/">🏠 Inicio</a></li>

                    <!-- Menú desplegable para Alumnos -->
                    <li>
                        <a href="#">🎓 Alumnos</a>
                        <ul class="dropdown">
                            <li><a href="/create-student">➕ Crear Estudiante</a></li>
                            <li><a href="/delete-student">❌ Eliminar Alumno</a></li>
                        </ul>
                    </li>

                    <!-- Menú desplegable para Cursos -->
                    <li>
                        <a href="#">📘 Cursos</a>
                        <ul class="dropdown">
                            <li><a href="/create-course">➕ Crear Curso</a></li>
                            <li><a href="/delete-course">❌ Eliminar Curso</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="main">
        <div class="container">
            <h2>Crear Curso</h2>

            <!-- Mensaje de Alerta -->
            <?php if ($message = session_flash('message')): ?>
                <div class="alert <?= session_flash('message_type') === 'error' ? 'alert-error' : 'alert-success' ?>">
                    <?= sanitize($message) ?>
                </div>
            <?php endif; ?>

            <!-- Formulario -->
            <form action="/store-course" method="POST" class="form">
                <div class="form-group">
                    <label for="name">Nombre del Curso:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="description">Descripción:</label>
                    <textarea id="description" name="description" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="department">Seleccionar Departamento:</label>
                    <select name="department_id" id="department" required>
                        <?php foreach ($departments as $department): ?>
                            <option value="<?= htmlspecialchars($department['id']) ?>">
                                <?= htmlspecialchars($department['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-primary">Crear</button>
            </form>

            <p>
                <a href="/enroll-student" class="btn-back">← Volver a la Matricula de Alumnos</a>
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