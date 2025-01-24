<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!empty($_SESSION['message'])): ?>
    <script>
        alert("<?= htmlspecialchars($_SESSION['message']) ?>");
    </script>
<?php
    unset($_SESSION['message'], $_SESSION['message_type']);
endif;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management</title>
    <link rel="stylesheet" href="/public/css/home.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>School Management System</h1>
            <nav>
                <ul class="nav-links">
                    <li><a href="/">Home</a></li>
                    <li><a href="/assign-teacher">Assign Teacher</a></li>
                    <li><a href="/enroll-student">Enroll Student</a></li>
                    <li><a href="/create-teacher">Create Teacher</a></li>
                    <li><a href="/create-student">Create Student</a></li>
                </ul>
            </nav>
        </div>
    </header>

    

    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> School Management System. All rights reserved.</p>
            <p>Contact us: <a href="mailto:support@schoolmanagement.com">support@schoolmanagement.com</a></p>
        </div>
    </footer>
</body>
</html>
