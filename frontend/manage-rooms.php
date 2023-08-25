<?php
require "../backend/Controllers/RoomsController.php";
require '../backend/Models/Rooms.php';

$controller = new RoomsController();
$rooms = new Rooms();
$rooms = $rooms->findAll();

render_component('head', ['title' => 'Manage Rooms']);
?>

<body>
    <?php render_component('menu'); ?>
    <main>
        <div class="container-fluid">
            <?php render_component('header', ['page' => 'Manage Rooms']); ?>
            <p>Add a <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">new room</a> if you want.</p>
            <section class="container-lg px-0">
                <!-- Button trigger modal -->

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Understood</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <?php foreach ($rooms as $room) : ?>
                        <div class="col-lg-4 mb-3">
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