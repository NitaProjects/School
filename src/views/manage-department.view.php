<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Departamentos</title>
    <link rel="stylesheet" href="/public/css/manage-departments.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <h1>Administrar Departamentos</h1>
            <nav>
                <ul class="nav-links">
                    <li><a href="/">🏠 Inicio</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <div class="table-header">
                <!-- Botón para abrir el modal de Crear Departamento -->
                <button type="button" class="btn-success" onclick="showCreateModal()">➕ Crear Departamento</button>
                <h2>Lista de Departamentos</h2>
            </div>

            <!-- Mensaje de Alerta -->
            <?php if ($message = session_flash('message')): ?>
                <div class="alert <?= session_flash('message_type') === 'error' ? 'alert-error' : 'alert-success' ?>">
                    <?= sanitize($message) ?>
                </div>
            <?php endif; ?>

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
                                <!-- Botones de acciones -->
                                <button type="button" class="btn-primary" onclick="prepareUpdateModal(<?= htmlspecialchars($department['id']) ?>, '<?= htmlspecialchars($department['name']) ?>', '<?= htmlspecialchars($department['description']) ?>')">Actualizar</button>
                                <button type="button" class="btn-danger" onclick="prepareDeleteModal(<?= htmlspecialchars($department['id']) ?>, '<?= htmlspecialchars($department['name']) ?>')">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modales -->
    <div id="createModal" class="modal" aria-hidden="true" aria-labelledby="createModalLabel">
        <div class="modal-content">
            <form action="/store-department" method="POST">
                <h3 id="createModalLabel">Crear Nuevo Departamento</h3>
                <label for="name-create">Nombre:</label>
                <input type="text" id="name-create" name="name" required>
                <label for="description-create">Descripción:</label>
                <textarea id="description-create" name="description" rows="3" required></textarea>
                <div class="modal-buttons">
                    <button type="submit" class="btn-primary">Crear</button>
                    <button type="button" class="btn-secondary" onclick="closeCreateModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="updateModal" class="modal" aria-hidden="true" aria-labelledby="updateModalLabel">
        <div class="modal-content">
            <form id="updateForm" method="POST">
                <h3 id="updateModalLabel">Actualizar Departamento</h3>
                <label for="name-update">Nombre:</label>
                <input type="text" id="name-update" name="name" required>
                <label for="description-update">Descripción:</label>
                <textarea id="description-update" name="description" rows="3" required></textarea>
                <div class="modal-buttons">
                    <button type="submit" class="btn-primary">Guardar Cambios</button>
                    <button type="button" class="btn-secondary" onclick="closeUpdateModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="modal" aria-hidden="true" aria-labelledby="deleteModalLabel">
        <div class="modal-content">
            <p id="deleteModalMessage"></p>
            <form id="deleteForm" method="POST">
                <div class="modal-buttons">
                    <button type="submit" class="btn-danger">Sí, eliminar</button>
                    <button type="button" class="btn-secondary" onclick="closeDeleteModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> San Daniel. Todos los derechos reservados.</p>
            <p>Contacto: <a href="mailto:soporte@sandaniel.com">Daniel es un crack</a></p>
        </div>
    </footer>

    <script>
        function showCreateModal() {
            document.getElementById('createModal').style.display = 'flex';
            document.getElementById('name-create').focus();
        }

        function closeCreateModal() {
            document.getElementById('createModal').style.display = 'none';
        }

        function prepareUpdateModal(id, name, description) {
            const updateModal = document.getElementById('updateModal');
            document.getElementById('updateForm').action = `/departments/${id}/update`;
            document.getElementById('name-update').value = name;
            document.getElementById('description-update').value = description;
            updateModal.style.display = 'flex';
        }

        function closeUpdateModal() {
            document.getElementById('updateModal').style.display = 'none';
        }

        function prepareDeleteModal(id, name) {
            const deleteModal = document.getElementById('deleteModal');
            document.getElementById('deleteForm').action = `/departments/${id}/delete`;
            document.getElementById('deleteModalMessage').textContent = `¿Estás seguro de que deseas eliminar el departamento "${name}"?`;
            deleteModal.style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }
    </script>
</body>

</html>