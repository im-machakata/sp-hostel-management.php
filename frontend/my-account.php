<?php
require_once __DIR__ . '/../backend/Controllers/AccountController.php';
$controller = new AccountController();
$user = new Users();
$user = $user->find(session('UserID'))->getRow();

render_component('head', ['title' => 'My Profile']); ?>

<body>
    <?php render_component('menu'); ?>
    <main class="container-fluid">
        <section class="login row justify-content-center">
            <!-- Header -->
            <div class="col-12 col-lg-12 text-lg-center">
                <?php render_component('header', ['page' => 'Profile']); ?>
            </div>

            <!-- Errors Layouts -->
            <?php if ($controller->hasErrors()) : ?>
                <div class="col-10 col-lg-6 px-0">
                    <div class="alert alert-danger"><?= $controller->getLastError() ?></div>
                </div>
                <div class="col-12"></div>
            <?php endif; ?>

            <!-- Register Form -->
            <div class="col-11 col-lg-6 my-2 border border-success rounded p-3 p-lg-4 mb-4">
                <form action="/my-account.php" method="post">
                    <div class="mb-3 form-floating">
                        <input type="text" class="form-control" placeholder="Student ID" id="student-id" name="student-id" value="<?= $user['username'] ?>" required>
                        <label for="student-id" class="form-label">Student ID</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" value="" required>
                        <label for="password" class="form-label">Password</label>
                    </div>
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" role="switch" value="" id="admin" <?= $user['is_admin'] ? 'checked' : '' ?> disabled>
                        <label class="form-check-label" for="admin">
                            Is Adminstrator
                        </label>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100">Update Account</button>
                </form>
            </div>
        </section>
    </main>
    <?php render_component('footer'); ?>
</body>

</html>