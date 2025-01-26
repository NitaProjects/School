<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Departamento</title>
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
            <h2>Eliminar Departamento</h2>

            <!-- Mensaje de Alerta -->
            <?php if ($message = session_flash('message')): ?>
                <div class="alert <?= session_flash('message_type') === 'error' ? 'alert-error' : 'alert-success' ?>">
                    <?= sanitize($message) ?>
                </div>
            <?php endif; ?>

            <h3>Lista de Departamentos</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($departments as $department): ?>
                        <tr>
                            <td><?= htmlspecialchars($department['id']) ?></td>
                            <td><?= htmlspecialchars($department['name']) ?></td>
                            <td><?= htmlspecialchars($department['description']) ?></td>
                            <td>
                                <form id="deleteForm-<?= htmlspecialchars($department['id']) ?>" action="/departments/<?= htmlspecialchars($department['id']) ?>/delete" method="POST">
                                    <button type="button" class="btn-danger" onclick="showModal(<?= htmlspecialchars($department['id']) ?>)">Eliminar</button>
                                </form>

                                <!-- Modal -->
                                <div id="confirmationModal-<?= htmlspecialchars($department['id']) ?>" class="modal">
                                    <div class="modal-content">
                                        <p>¿Estás seguro de que deseas eliminar el departamento "<?= htmlspecialchars($department['name']) ?>"?</p>
                                        <button class="btn-danger" onclick="submitForm(<?= htmlspecialchars($department['id']) ?>)">Sí, eliminar</button>
                                        <button class="btn-secondary" onclick="closeModal(<?= htmlspecialchars($department['id']) ?>)">Cancelar</button>
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
    function showModal(departmentId) {
        document.getElementById(`confirmationModal-${departmentId}`).style.display = 'block';
    }

    function closeModal(departmentId) {
        document.getElementById(`confirmationModal-${departmentId}`).style.display = 'none';
    }

    function submitForm(departmentId) {
        document.getElementById(`deleteForm-${departmentId}`).submit();
    }
</script>

</html>
