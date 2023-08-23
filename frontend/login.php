<?php
require_once __DIR__ . '/../backend/Controllers/LoginController.php';
$controller = new LoginController();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <title>Login - Hostel Management System</title>
</head>

<body>
    <main class="container-fluid">
        <section class="login row jumbotron justify-content-center">
            <!-- Header -->
            <div class="col-11 col-lg-12 text-lg-center">
                <h1 class="pt-4 mt-lg-4 display-5">Sign In > Hostelia</h1>
                <p class="lead">The ultimate solution for all students looking for accomadation.</p>
            </div>

            <!-- Errors Layouts -->
            <?php if ($controller->hasErrors()) : ?>
                <div class="col-10 col-lg-6 px-0">
                    <div class="alert alert-danger"><?= $controller->getLastError() ?></div>
                </div>
                <div class="col-12"></div>
            <?php endif; ?>

            <!-- Login Form -->
            <div class="col-10 col-lg-6 my-2 border border-success rounded p-3 p-lg-4 mb-4">
                <form action="/login.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" placeholder="Username" id="username" name="username" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100">Login</button>
                    <p class="mt-4 mb-1 text-lg-center">Don't have an account? <a href="/create-account.php">Create one</a> for free.</p>
                </form>
            </div>
        </section>
    </main>

    <footer class="d-flex flex-wrap justify-content-center align-items-center py-4 my-4 border-top border-success">
        <div class="d-flex align-items-center">
            <span class="text-muted">Copyright of &copy;<?= SCHOOL_NAME . ', ' . date('Y') ?></span>
        </div>
    </footer>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>