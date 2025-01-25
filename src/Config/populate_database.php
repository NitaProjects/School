<?php

require 'db_connection.php'; // Asegúrate de conectar con tu base de datos

function generateRandomEmail($name) {
    $domains = ['hotmail.com', 'gmail.com', 'yahoo.com', 'example.com'];
    $formattedName = strtolower(str_replace(' ', '.', $name));
    return $formattedName . rand(1, 99) . '@' . $domains[array_rand($domains)];
}

function generateRandomDate($startYear, $endYear) {
    $timestamp = mt_rand(strtotime("$startYear-01-01"), strtotime("$endYear-12-31"));
    return date('Y-m-d', $timestamp);
}

function insertUsers($pdo, $name, $email, $userType) {
    $stmt = $pdo->prepare("
        INSERT INTO users (name, email, password, user_type) 
        VALUES (:name, :email, :password, :user_type)
    ");
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'password' => password_hash('password', PASSWORD_DEFAULT),
        'user_type' => $userType
    ]);
    return $pdo->lastInsertId(); // Retorna el ID generado
}

function insertStudent($pdo, $userId) {
    $enrollmentDate = generateRandomDate(2020, 2025);
    $stmt = $pdo->prepare("
        INSERT INTO students (user_id, enrollment_date) 
        VALUES (:user_id, :enrollment_date)
    ");
    $stmt->execute([
        'user_id' => $userId,
        'enrollment_date' => $enrollmentDate
    ]);
}

function insertTeacher($pdo, $userId) {
    $hireDate = generateRandomDate(2015, 2025);
    $stmt = $pdo->prepare("
        INSERT INTO teachers (user_id, hire_date) 
        VALUES (:user_id, :hire_date)
    ");
    $stmt->execute([
        'user_id' => $userId,
        'hire_date' => $hireDate
    ]);
}

function insertDepartment($pdo, $name, $description) {
    $stmt = $pdo->prepare("
        INSERT INTO departments (name, description) 
        VALUES (:name, :description)
    ");
    $stmt->execute([
        'name' => $name,
        'description' => $description
    ]);
    return $pdo->lastInsertId(); // Retorna el ID del departamento
}

function insertCourse($pdo, $departmentId, $name, $description) {
    $stmt = $pdo->prepare("
        INSERT INTO courses (department_id, name, description) 
        VALUES (:department_id, :name, :description)
    ");
    $stmt->execute([
        'department_id' => $departmentId,
        'name' => $name,
        'description' => $description
    ]);
}

// Listado de nombres secuenciales para evitar duplicados
$departments = ['Matemáticas', 'Ciencias', 'Historia', 'Idiomas', 'Arte'];
$coursesPerDepartment = [
    'Matemáticas' => ['Álgebra', 'Cálculo', 'Estadística', 'Geometría', 'Matemáticas Aplicadas'],
    'Ciencias' => ['Biología', 'Física', 'Química', 'Ecología', 'Astronomía'],
    'Historia' => ['Historia Mundial', 'Historia Moderna', 'Antigüedad', 'Historiografía', 'Historia de América'],
    'Idiomas' => ['Inglés', 'Español', 'Francés', 'Alemán', 'Italiano'],
    'Arte' => ['Pintura', 'Escultura', 'Dibujo', 'Historia del Arte', 'Fotografía']
];

// Insertar estudiantes y profesores
try {
    // Generar 30 estudiantes
    for ($i = 0; $i < 30; $i++) {
        $name = "Estudiante $i";
        $email = generateRandomEmail($name);
        $userId = insertUsers($pdo, $name, $email, 'student'); // Insertar en users
        insertStudent($pdo, $userId); // Insertar en students
    }

    // Generar 30 profesores
    for ($i = 0; $i < 30; $i++) {
        $name = "Profesor $i";
        $email = generateRandomEmail($name);
        $userId = insertUsers($pdo, $name, $email, 'teacher'); // Insertar en users
        insertTeacher($pdo, $userId); // Insertar en teachers
    }

    // Insertar departamentos y cursos secuencialmente
    foreach ($departments as $departmentName) {
        $departmentId = insertDepartment($pdo, $departmentName, "Departamento de $departmentName.");
        foreach ($coursesPerDepartment[$departmentName] as $courseName) {
            insertCourse($pdo, $departmentId, $courseName, "Curso de $courseName en el departamento de $departmentName.");
        }
    }

    echo "Registros creados exitosamente.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
