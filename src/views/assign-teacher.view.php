<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Teacher to Department</title>
    <link rel="stylesheet" href="/public/css/managment.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <h1>School Management System</h1>
            <nav>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/assign-teacher">Assign Teacher</a></li>
                    <li><a href="/create-teacher">Create Teacher</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <h2>Assign Teacher to Department</h2>

            <?php if ($message = session_flash('message')): ?>
                <div class="alert">
                    <?= sanitize($message) ?>
                </div>
            <?php endif; ?>

            <form action="/assign-teacher" method="POST" class="form">
                <div class="form-group">
                    <label for="teacher">Select Teacher:</label>
                    <select name="teacher_id" id="teacher" required>
                        <?php foreach ($teachers as $teacher): ?>
                            <option value="<?= htmlspecialchars($teacher['id']) ?>">
                                <?= htmlspecialchars($teacher['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="department">Select Department:</label>
                    <select name="department_id" id="department" required>
                        <?php foreach ($departments as $department): ?>
                            <option value="<?= htmlspecialchars($department['id']) ?>">
                                <?= htmlspecialchars($department['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-primary">Assign</button>
            </form>

            <h3>Current Assignments</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Teacher</th>
                        <th>Department</th>
                        <th>Assigned Date</th>
                        <th>Actions</th>
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
                                    <button type="submit" class="btn-danger">Delete</button>
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
            <p>&copy; 2025 School Management System. All rights reserved.</p>
            <p>Contact us: <a href="mailto:support@schoolmanagement.com">support@schoolmanagement.com</a></p>
        </div>
    </footer>
</body>

</html>