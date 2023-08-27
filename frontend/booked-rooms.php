<?php
require "../backend/Controllers/RoomsController.php";
require '../backend/Models/Rooms.php';

$controller = new RoomsController();
$rooms = new Rooms();
$rooms = $rooms->getBookings();

render_component('head', ['title' => 'View Bookings']);
?>

<body>
    <?php render_component('menu'); ?>
    <main>
        <div class="container-fluid">
            <?php render_component('header', ['page' => 'View Bookings']); ?>
            <section class="px-0">
                <!-- Errors Layouts -->
                <?php if ($controller->hasErrors() && $controller->request->isPost()) : ?>
                    <div class="alert alert-danger"><?= $controller->getLastError() ?></div>
                <?php elseif ($controller->request->isPost() && !$controller->hasErrors()) : ?>
                    <div class="alert alert-success">
                        <?php
                        if ($controller->request->getVar('action') == 'edit') {
                            echo 'Room has been updated.';
                        } elseif ($controller->request->getVar('action') == 'delete') {
                            echo 'Selected room has been deleted.';
                        } else {
                            echo 'New room has been captured.';
                        } ?>
                    </div>
                <?php endif; ?>

                <div class="row mt-2 justify-content-center">
                    <?php foreach ($rooms as $room) : ?>
                        <div class="col-lg-3 mb-3">
                            <?php render_component('room', $room) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
    </main>
    <?php render_component('footer'); ?>
</body>

</html>