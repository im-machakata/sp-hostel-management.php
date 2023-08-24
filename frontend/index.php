<?php
require "../backend/Controllers/HomeController.php";
require '../backend/Models/Rooms.php';

$controller = new HomeController();
$rooms = new Rooms();
$available_rooms = $rooms->getFreeRooms();
$all_rooms = $rooms->countAllRooms()['total'];
$percentage_free = number_format(((count($available_rooms) / $all_rooms) * 100));

render_component('head', ['title' => 'Home']);
?>

<body>
    <?php render_component('menu'); ?>
    <main class="container-fluid">
        <?php render_component('header', ['page' => 'Dashboard']); ?>
        <section class="row justify-content-center">
            <div class="col-lg-6 mb-3 mb-lg-4">
                <div class="progress rounded">
                    <div class="progress-bar bg-success progress-bar-striped" role="progressbar" style="width: <?= $percentage_free ?>%" aria-valuenow="<?= $percentage_free ?>" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="left" title="Free Rooms"><?= $percentage_free ?>% Free</div>
                    <div class="progress-bar bg-warning progress-bar-striped text-dark" role="progressbar" style="width: <?= (100 - $percentage_free) ?>%" aria-valuenow="<?= (100 - $percentage_free) ?>" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="right" title="Booked Rooms"><?= 100-$percentage_free ?>% Booked</div>
                </div>
            </div>
            <div class="col-12"></div>
            <?php foreach ($available_rooms as $room) : ?>
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-success">
                        <div class="ratio ratio-16x9">
                            <img src="<?= $room['image_url'] ?? ('/assets/images/demo.jpg') ?>" class="card-img-top img-fluid" alt="<?= $room['name'] ?> Image">
                        </div>
                        <div class="card-body">
                            <div class="text-dark h5 badge bg-warning mb-2">
                                USD $<?= number_format($room['cost'], 2) ?>
                            </div>
                            <h2 class="card-title"><?= $room['name'] ?></h2>
                            <p class="card-text"><?= $room['description'] ?></p>
                            <a href="/book-room.php?id=<?= $room['id'] ?>" class="btn btn-outline-success">Book This Room</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
    <?php render_component('footer'); ?>
</body>

</html>