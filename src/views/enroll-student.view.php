<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matricular Estudiante en Curso</title>
    <link rel="stylesheet" href="/public/css/enroll-student.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <h1>Matricular Estudiante a un Curso</h1>
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
            <h2></h2>

            <!-- Mensaje de Alerta -->
            <?php if ($message = session_flash('message')): ?>
                <div class="alert <?= session_flash('message_type') === 'error' ? 'alert-error' : 'alert-success' ?>">
                    <?= sanitize($message) ?>
                </div>
            <?php endif; ?>

            <!-- Formulario de Matrícula -->
            <form action="/enroll-student" method="POST" class="form">
                <div class="form-group">
                    <label for="student">Seleccionar Estudiante:</label>
                    <select name="student_id" id="student" required>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= htmlspecialchars($student['student_id']) ?>">
                                <?= htmlspecialchars($student['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="course">Seleccionar Curso:</label>
                    <select name="course_id" id="course" required>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?= htmlspecialchars($course['id']) ?>">
                                <?= htmlspecialchars($course['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-primary">Matricular</button>
            </form>

            <h3>Matrículas Actuales</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Curso</th>
                        <th>Fecha de Matrícula</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enrollments as $enrollment): ?>
                        <tr>
                            <td><?= htmlspecialchars($enrollment['student_name']) ?></td>
                            <td><?= htmlspecialchars($enrollment['course_name']) ?></td>
                            <td><?= htmlspecialchars($enrollment['enrollment_date']) ?></td>
                            <td>
                                <form action="/enrollments/<?= htmlspecialchars($enrollment['enrollment_id']) ?>/delete" method="POST">
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