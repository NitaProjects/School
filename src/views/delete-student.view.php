<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Alumno</title>
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
            <h2>Eliminar Alumno</h2>

            <!-- Mensaje de Alerta -->
            <?php if ($message = session_flash('message')): ?>
                <div class="alert <?= session_flash('message_type') === 'error' ? 'alert-error' : 'alert-success' ?>">
                    <?= sanitize($message) ?>
                </div>
            <?php endif; ?>

            <h3>Lista de Estudiantes</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Fecha de Matriculación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= htmlspecialchars($student['user_id']) ?></td>
                            <td><?= htmlspecialchars($student['name']) ?></td>
                            <td><?= htmlspecialchars($student['email']) ?></td>
                            <td><?= htmlspecialchars($student['enrollment_date']) ?></td>
                            <td>
                                <form id="deleteForm-<?= htmlspecialchars($student['user_id']) ?>" action="/students/<?= htmlspecialchars($student['user_id']) ?>/delete" method="POST">
                                    <button type="button" class="btn-danger" onclick="showModal(<?= htmlspecialchars($student['user_id']) ?>)">Eliminar</button>
                                </form>

                                <div id="confirmationModal-<?= htmlspecialchars($student['user_id']) ?>" class="modal">
                                    <div class="modal-content">
                                        <p>¿Estás seguro de que deseas eliminar a <?= htmlspecialchars($student['name']) ?>?</p>
                                        <button class="btn-danger" onclick="submitForm(<?= htmlspecialchars($student['user_id']) ?>)">Sí, eliminar</button>
                                        <button class="btn-secondary" onclick="closeModal(<?= htmlspecialchars($student['user_id']) ?>)">Cancelar</button>
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
    function showModal(userId) {
        document.getElementById(`confirmationModal-${userId}`).style.display = 'block';
    }

    function closeModal(userId) {
        document.getElementById(`confirmationModal-${userId}`).style.display = 'none';
    }

    function submitForm(userId) {
        document.getElementById(`deleteForm-${userId}`).submit();
    }
</script>

</html>