<?php
require_once __DIR__ . '/../backend/Controllers/LoginController.php';
$controller = new LoginController();

render_component('head', ['title' => 'Login']);
?>


<body>
    <main class="container-fluid">
        <section class="login row jumbotron justify-content-center">
            <!-- Header -->
            <div class="col-11 col-lg-12 text-lg-center">
                <?php render_component('header', ['page' => 'Login']); ?>
            </div>

            <!-- Errors Layouts -->
            <?php if ($controller->hasErrors()) : ?>
                <div class="col-10 col-lg-6 px-0">
                    <div class="alert alert-danger border-danger"><?= $controller->getLastError() ?></div>
                </div>
                <div class="col-12"></div>
            <?php endif; ?>

            <!-- Login Form -->
            <div class="col-10 col-lg-6 my-2 border border-success rounded p-3 p-lg-4 mb-4">
                <form action="/login.php" method="post">
                    <div class="mb-3 form-floating">
                        <input type="text" class="form-control" placeholder="Username" id="username" name="username" value="<?= $controller->request->getVar('username') ?>" required>
                        <label for="username" class="form-label">Username</label>
                    </div>
                    <div class="mb-4 form-floating">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" value="<?= $controller->request->getVar('password') ?>" required>
                        <label for="password" class="form-label">Password</label>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100">Login</button>
                    <p class="mt-4 mb-1 text-lg-center">Don't have an account? <a href="/create-account.php">Create one</a> for free.</p>
                </form>
            </div>
        </section>
    </main>

    <?php render_component('footer'); ?>
</body>

</html>