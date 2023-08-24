<?php
require_once __DIR__ . '/../backend/Controllers/RegisterController.php';
$controller = new RegisterController();

render_component('head', ['title' => 'Register']); ?>

<body>
    <main class="container-fluid">
        <section class="login row jumbotron justify-content-center">
            <!-- Header -->
            <div class="col-11 col-lg-12 text-lg-center">
                <?php render_component('header', ['page' => 'Register']); ?>
            </div>

            <!-- Errors Layouts -->
            <?php if ($controller->hasErrors()) : ?>
                <div class="col-10 col-lg-6 px-0">
                    <div class="alert alert-danger"><?= $controller->getLastError() ?></div>
                </div>
                <div class="col-12"></div>
            <?php endif; ?>

            <!-- Register Form -->
            <div class="col-10 col-lg-6 my-2 border border-success rounded p-3 p-lg-4 mb-4">
                <form action="/create-account.php" method="post">
                    <div class="mb-3 form-floating">
                        <input type="text" class="form-control" placeholder="Student ID" id="student-id" name="student-id" required>
                        <label for="student-id" class="form-label">Student ID</label>
                    </div>
                    <div class="mb-4 form-floating">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                        <label for="password" class="form-label">Password</label>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100">Create Account</button>
                    <p class="mt-4 mb-1 text-lg-center">Already have an account? <a href="/login.php">Login</a> to your account.</p>
                </form>
            </div>
        </section>
    </main>
    <?php render_component('footer'); ?>
</body>

</html>