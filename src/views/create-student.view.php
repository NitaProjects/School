<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Student</title>
    <link rel="stylesheet" href="/public/css/formularios.css">
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <h1>School Management System</h1>
            <nav>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/assign-teacher">Assign Teacher</a></li>
                    <li><a href="/enroll-student">Enroll Student</a></li>
                    <li><a href="/create-student">Create Student</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main">
        <div class="container">
            <h2>Create Student</h2>

            <!-- Alert Message -->
            <?php if ($message = session_flash('message')): ?>
                <div class="alert">
                    <?= sanitize($message) ?>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form action="/store-student" method="POST" class="form">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="enrollment_date">Enrollment Date:</label>
                    <input type="date" id="enrollment_date" name="enrollment_date" required>
                </div>

                <button type="submit" class="btn-primary">Create</button>
            </form>

            <p>
                <a href="/enroll-student" class="btn-back">← Back to Students List</a>
            </p>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 School Management System. All rights reserved.</p>
            <p>Contact us: <a href="mailto:support@schoolmanagement.com">support@schoolmanagement.com</a></p>
        </div>
    </footer>
</body>

</html>
