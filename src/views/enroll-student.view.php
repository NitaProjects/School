<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll Student in Course</title>
    <link rel="stylesheet" href="/public/css/managment.css">
</head>

<body>
    <header>
        <div class="container">
            <h1>School Management System</h1>
            <nav>
                <a href="/">Home</a>
                <a href="/assign-teacher">Assign Teacher</a>
                <a href="/enroll-student">Enroll Student</a>
                <a href="/create-teacher">Create Teacher</a>
                <a href="/create-student">Create Student</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <h2>Enroll Student in Course</h2>

            <div class="actions">
                <a href="/" class="btn">← Back to Home</a>
                <a href="/create-student" class="btn">+ Create Student</a>
            </div>

            <?php if ($message = session_flash('message')): ?>
                <script>
                    alert("<?= sanitize($message) ?>");
                </script>
            <?php endif; ?>

            <form action="/enroll-student" method="POST" class="form-card">
                <label for="student">Select Student:</label>
                <select name="student_id" id="student" required>
                    <?php foreach ($students as $student): ?>
                        <option value="<?= htmlspecialchars($student['id']) ?>">
                            <?= htmlspecialchars($student['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="course">Select Course:</label>
                <select name="course_id" id="course" required>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?= htmlspecialchars($course['id']) ?>">
                            <?= htmlspecialchars($course['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="btn btn-primary">Enroll</button>
            </form>

            <h3>Current Enrollments</h3>
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Enrollment Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enrollments as $enrollment): ?>
                        <tr>
                            <td><?= htmlspecialchars($enrollment['student_name']) ?></td>
                            <td><?= htmlspecialchars($enrollment['course_name']) ?></td>
                            <td><?= htmlspecialchars($enrollment['enrollment_date']) ?></td>
                            <td>
                                <form action="/enrollments/<?= htmlspecialchars($enrollment['enrollment_id']) ?>/delete" method="POST" style="display:inline;">
                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>© 2025 School Management System. All rights reserved.</p>
            <p>Contact us: <a href="mailto:support@schoolmanagement.com">support@schoolmanagement.com</a></p>
        </div>
    </footer>
</body>

</html>
