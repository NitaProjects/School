<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Curso</title>
    <link rel="stylesheet" href="/public/css/delete.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <h1>Sistema de Gestión Escolar</h1>
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

    <main class="main">
        <div class="container">
            <h2>Eliminar Curso</h2>

            <!-- Mensaje de Alerta -->
            <?php if ($message = session_flash('message')): ?>
                <div class="alert <?= session_flash('message_type') === 'error' ? 'alert-error' : 'alert-success' ?>">
                    <?= sanitize($message) ?>
                </div>
            <?php endif; ?>

            <h3>Lista de Cursos</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Departamento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $course): ?>
                        <tr>
                            <td><?= htmlspecialchars($course['id']) ?></td>
                            <td><?= htmlspecialchars($course['name']) ?></td>
                            <td><?= htmlspecialchars($course['description']) ?></td>
                            <td><?= htmlspecialchars($course['department_name']) ?></td>
                            <td>
                                <form id="deleteForm-<?= htmlspecialchars($course['id']) ?>" action="/courses/<?= htmlspecialchars($course['id']) ?>/delete" method="POST">
                                    <button type="button" class="btn-danger" onclick="showModal(<?= htmlspecialchars($course['id']) ?>)">Eliminar</button>
                                </form>

                                <!-- Modal -->
                                <div id="confirmationModal-<?= htmlspecialchars($course['id']) ?>" class="modal">
                                    <div class="modal-content">
                                        <p>¿Estás seguro de que deseas eliminar el curso "<?= htmlspecialchars($course['name']) ?>"?</p>
                                        <button class="btn-danger" onclick="submitForm(<?= htmlspecialchars($course['id']) ?>)">Sí, eliminar</button>
                                        <button class="btn-secondary" onclick="closeModal(<?= htmlspecialchars($course['id']) ?>)">Cancelar</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> San Daniel. Todos los derechos reservados.</p>
            <p>Contacto: <a href="mailto:soporte@sandaniel.com">Daniel es un crack</a></p>
        </div>
    </footer>
</body>

<script>
    function showModal(courseId) {
        document.getElementById(`confirmationModal-${courseId}`).style.display = 'block';
    }

    function closeModal(courseId) {
        document.getElementById(`confirmationModal-${courseId}`).style.display = 'none';
    }

    function submitForm(courseId) {
        document.getElementById(`deleteForm-${courseId}`).submit();
    }
</script>

</html>
