<?php
require_once __DIR__ . '/../backend/Controllers/RegisterController.php';
$controller = new RegisterController();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <title>Create Account - Hostel Management System</title>
</head>

<body>
    <main class="container-fluid">
        <section class="login row jumbotron justify-content-center">
            <!-- Header -->
            <div class="col-11 col-lg-12 text-lg-center">
                <h1 class="pt-4 mt-lg-4 display-5">Hostel Management</h1>
                <p class="lead">The ultimate solution for all students looking for accomadation.</p>
            </div>

            <!-- Errors Layouts -->
            <?php if ($controller->hasErrors()) : ?>
                <div class="col-10 col-lg-6 px-0">
                    <div class="alert alert-danger rounded-0"><?= $controller->getLastError() ?></div>
                </div>
                <div class="col-12"></div>
            <?php endif; ?>

            <!-- Register Form -->
            <div class="col-10 col-lg-6 my-2 border border-success p-3 p-lg-4 mb-4">
                <form action="/create-account.php" method="post">
                    <div class="mb-3">
                        <label for="student-id" class="form-label">Student ID</label>
                        <input type="text" class="form-control rounded-0" placeholder="Student ID" id="student-id" name="student-id" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control rounded-0" placeholder="Password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success rounded-0 btn-lg w-100">Create Account</button>
                    <p class="mt-4 mb-1 text-lg-center">Already have an account? <a href="/login.php">Login</a> to your account.</p>
                </form>
            </div>
        </section>
    </main>

    <script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>