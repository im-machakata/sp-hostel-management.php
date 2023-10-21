<?php
require "../backend/Controllers/HomeController.php";
require '../backend/Models/Rooms.php';

$controller = new HomeController();
$rooms = new Rooms();
$available_rooms = $rooms->getFreeRooms();
$all_rooms = $rooms->countAllRooms()['total'];

// calculate percentage free or set it to 0 when there's no
$percentage_free = $all_rooms ? number_format(((count($available_rooms) / $all_rooms) * 100)) : 0;

render_component('head', ['title' => 'Home']);
?>

<body>
    <?php render_component('menu'); ?>
    <main class="container-fluid">
        <?php render_component('header', ['page' => 'Dashboard']); ?>
        <section class="row justify-content-center">
            <div class="col-lg-6 mb-3 mb-lg-4">
                <div class="progress rounded">
                    <div class="progress-bar bg-warning progress-bar-striped text-dark" role="progressbar" style="width: <?= (100 - $percentage_free) ?>%" aria-valuenow="<?= (100 - $percentage_free) ?>" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="right" title="Booked Rooms"><?= $all_rooms - count($available_rooms) ?> Rooms Reserved</div>
                    <div class="progress-bar bg-success progress-bar-striped" role="progressbar" style="width: <?= $percentage_free ?>%" aria-valuenow="<?= $percentage_free ?>" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="left" title="Free Rooms"><?= count($available_rooms) ?> Rooms Available</div>
                </div>
            </div>
            <div class="col-12"></div>
            <?php foreach ($available_rooms as $room) : ?>
                <div class="col-sm-6 col-lg-3">
                    <?php render_component('room', $room); ?>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
    <?php render_component('footer'); ?>
</body>

</html>