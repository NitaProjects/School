<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Departamento</title>
    <link rel="stylesheet" href="/public/css/update.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <h1>Actualizar Departamento</h1>
            <nav>
                <ul class="nav-links">
                    <li><a href="/">🏠 Inicio</a></li>
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
            <h2></h2>

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
                                <button type="button" class="btn-primary" onclick="showUpdateModal(<?= htmlspecialchars($department['id']) ?>)">
                                    Actualizar
                                </button>

                                <!-- Modal -->
                                <div id="updateModal-<?= htmlspecialchars($department['id']) ?>" class="modal">
                                    <div class="modal-content">
                                        <form action="/departments/<?= htmlspecialchars($department['id']) ?>/update" method="POST">
                                            <h3>Actualizar Departamento</h3>
                                            <label for="name-<?= htmlspecialchars($department['id']) ?>">Nombre:</label>
                                            <input type="text" id="name-<?= htmlspecialchars($department['id']) ?>" name="name" value="<?= htmlspecialchars($department['name']) ?>" required>

                                            <label for="description-<?= htmlspecialchars($department['id']) ?>">Descripción:</label>
                                            <textarea id="description-<?= htmlspecialchars($department['id']) ?>" name="description" rows="3" required><?= htmlspecialchars($department['description']) ?></textarea>

                                            <div class="modal-buttons">
                                                <button type="submit" class="btn-primary">Guardar Cambios</button>
                                                <button type="button" class="btn-secondary" onclick="closeUpdateModal(<?= htmlspecialchars($department['id']) ?>)">Cancelar</button>
                                            </div>
                                        </form>
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
    function showUpdateModal(departmentId) {
        const modal = document.getElementById(`updateModal-${departmentId}`);
        modal.style.display = 'flex';

        // Enfocar el campo de nombre al abrir el modal
        const nameField = document.getElementById(`name-${departmentId}`);
        if (nameField) {
            nameField.focus();
        }
    }

    function closeUpdateModal(departmentId) {
        const modal = document.getElementById(`updateModal-${departmentId}`);
        modal.style.display = 'none';
    }
</script>

</html>