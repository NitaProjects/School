<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Profesor al Departamento</title>
    <link rel="stylesheet" href="/public/css/assign-teacher.css">
</head>

<body>
    <header class="header">
        <div class="container"> 
            <h1>Asignar Profesor a un Departamento</h1>
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
                            <li><a href="/update-department">✏️ Editar Departamento</a></li>
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

            <!-- Formulario de Asignación -->
            <form action="/assign-teacher" method="POST" class="form">
                <div class="form-group">
                    <label for="teacher">Seleccionar Profesor:</label>
                    <!-- <pre><?php var_dump($teachers); ?></pre> -->
                    <select name="teacher_id" id="teacher" required>
                        <?php foreach ($teachers as $teacher): ?>
                            <option value="<?= htmlspecialchars($teacher['teacher_id']) ?>">
                                <?= htmlspecialchars($teacher['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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

                <button type="submit" class="btn-primary">Asignar</button>
            </form>

            <h3>Asignaciones Actuales</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Profesor</th>
                        <th>Departamento</th>
                        <th>Fecha de Asignación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assignments as $assignment): ?>
                        <tr>
                            <td><?= htmlspecialchars($assignment['teacher_name']) ?></td>
                            <td><?= htmlspecialchars($assignment['department_name']) ?></td>
                            <td><?= htmlspecialchars($assignment['assigned_date']) ?></td>
                            <td>
                                <form action="/assignments/<?= htmlspecialchars($assignment['assignment_id']) ?>/delete" method="POST">
                                    <button type="submit" class="btn-danger">Eliminar</button>
                                </form>
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

</html>
