<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>San Daniel</title>
    <link rel="icon" type="image/x-icon" href="/favicon2.ico">
    <link rel="stylesheet" href="/public/css/home.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <h1>San Daniel</h1>
            <nav>
                <ul class="nav-links">
                    <!-- Enlaces Principales -->
                    <li><a href="/assign-teacher">👨‍🏫 Asignar Profesor</a></li>
                    <li><a href="/enroll-student">📝 Matricular Estudiante</a></li>

                    <!-- Menús Desplegables -->
                    <li>
                        <a href="#">📘 Cursos</a>
                        <ul class="dropdown">
                            <li><a href="/create-course">➕ Crear Curso</a></li>
                            <li><a href="/delete-course">❌ Eliminar Curso</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">🏢 Departamentos</a>
                        <ul class="dropdown">
                            <li><a href="/create-department">➕ Crear Departamento</a></li>
                            <li><a href="/delete-department">❌ Eliminar Departamento</a></li>
                            <li><a href="/update-department">✏️ Editar Departamento</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="#">🎓 Alumnos</a>
                        <ul class="dropdown">
                            <li><a href="/create-student">➕ Crear Estudiante</a></li>
                            <li><a href="/delete-student">❌ Eliminar Alumno</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">📚 Profesores</a>
                        <ul class="dropdown">
                            <li><a href="/create-teacher">➕ Crear Profesor</a></li>
                            <li><a href="/delete-teacher">❌ Eliminar Profesor</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> San Daniel. Todos los derechos reservados.</p>
            <p>Contacto: <a href="mailto:soporte@sandaniel.com">Daniel es un crack</a></p>
        </div>
    </footer>
</body>

</html>