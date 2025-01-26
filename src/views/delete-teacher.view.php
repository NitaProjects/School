<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Profesor</title>
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
                            <li><a href="/create-department">➕ Crear Departamento</a></li>
                            <li><a href="/delete-department">❌ Eliminar Departamento</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <h2>Eliminar Profesor</h2>

            <!-- Mensaje de Alerta -->
            <?php if ($message = session_flash('message')): ?>
                <div class="alert <?= session_flash('message_type') === 'error' ? 'alert-error' : 'alert-success' ?>">
                    <?= sanitize($message) ?>
                </div>
            <?php endif; ?>

            <h3>Lista de Profesores</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Fecha de Contratación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($teachers as $teacher): ?>
                        <tr>
                            <td><?= htmlspecialchars($teacher['user_id']) ?></td>
                            <td><?= htmlspecialchars($teacher['name']) ?></td>
                            <td><?= htmlspecialchars($teacher['email']) ?></td>
                            <td><?= htmlspecialchars($teacher['hire_date']) ?></td>
                            <td>
                                <form id="deleteForm-<?= htmlspecialchars($teacher['user_id']) ?>" action="/teachers/<?= htmlspecialchars($teacher['user_id']) ?>/delete" method="POST">
                                    <button type="button" class="btn-danger" onclick="showModal(<?= htmlspecialchars($teacher['user_id']) ?>)">Eliminar</button>
                                </form>

                                <!-- Modal -->
                                <div id="confirmationModal-<?= htmlspecialchars($teacher['user_id']) ?>" class="modal">
                                    <div class="modal-content">
                                        <p>¿Estás seguro de que deseas eliminar a <?= htmlspecialchars($teacher['name']) ?>?</p>
                                        <button class="btn-danger" onclick="submitForm(<?= htmlspecialchars($teacher['user_id']) ?>)">Sí, eliminar</button>
                                        <button class="btn-secondary" onclick="closeModal(<?= htmlspecialchars($teacher['user_id']) ?>)">Cancelar</button>
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