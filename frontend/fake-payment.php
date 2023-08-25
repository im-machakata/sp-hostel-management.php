<?php
require "../backend/Controllers/PaymentsController.php";

$controller = new PaymentsController();

render_component('head', ['title' => 'Fake a payment']); ?>

<body>
    <?php render_component('menu'); ?>
    <main>
        <div class="container-fluid">
            <section class="container">
                <?php render_component('header', ['page' => 'Fake Payment']); ?>
                <div class="row justify-content-center mt-4">
                    <!-- Errors Layouts -->
                    <?php if ($controller->hasErrors()) : ?>
                        <div class="col-11 col-lg-6">
                            <div class="alert alert-danger text-lg-center mt-1 mb-4">
                                <?= $controller->getLastError() ?>
                            </div>
                        </div>
                        <div class="col-12"></div>
                    <?php endif; ?>
                    <form action="/fake-payment.php" method="get">
                        <div class="row justify-content-center mb-4">
                            <div class="col-lg-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" value="<?= $controller->request->get('id') ?>" placeholder="Payment" id="id" name="id" class="form-control">
                                    <label for="id" class="form-label">Payment ID</label>
                                </div>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" value="<?= $controller->request->get('status') ?>" placeholder="Payment" name="status" id="status" class="form-control">
                                    <label for="status" class="form-label">Payment Status</label>
                                </div>
                            </div>
                            <div class="col-12"></div>
                            <div class="col-lg-3">
                                <button class="btn btn-outline-success w-100 btn-lg" type="submit">Process</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
    <?php render_component('footer'); ?>
</body>

</html>