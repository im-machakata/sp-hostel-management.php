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
            <p class="d-flex justify-content-lg-center mb-5"><a href="#newRoom" data-bs-toggle="modal" data-bs-target="#newRoom" class="btn btn-outline-success col-lg-2" data-id="" data-action="new">Add New Room</a></p>
            <section class="px-0">
                <!-- Edit / New Room Modal -->
                <div class="modal fade" id="newRoom" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newRoomLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="newRoomLabel">New Room</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="/manage-rooms.php" method="post" enctype="multipart/form-data">
                                    <input id="roomID" type="hidden" name="id" value="null">
                                    <input id="formAction" type="hidden" name="action" value="new-room">
                                    <div class="mb-3 form-floating">
                                        <input type="text" class="form-control" placeholder="Room Name" id="roomName" name="roomName" required>
                                        <label for="roomName" class="form-label">Room Name</label>
                                    </div>
                                    <div class="mb-3 form-floating">
                                        <input type="number" class="form-control" placeholder="Room Price" id="roomPrice" name="roomPrice" required>
                                        <label for="roomPrice" class="form-label">Room Price</label>
                                    </div>
                                    <div class="mb-3 input-group">
                                        <input type="file" class="form-control" placeholder="Room Image" id="roomImage" name="roomImage">
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="roomBooked" name="roomBooked">
                                        <label class="form-check-label" for="roomBooked">
                                            The room is already booked
                                        </label>
                                    </div>
                                    <div class="mb-3 form-floating">
                                        <textarea type="text" class="form-control" placeholder="Room Description" id="roomDescription" name="roomDescription" style="height: 100px;" required></textarea>
                                        <label for="roomDescription" class="form-label">Room Description</label>
                                    </div>
                                    <hr class="mt-2">
                                    <div class="my-2 px-1 text-end">
                                        <button type="button" class="btn btn-outline-dark w-25" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success w-25">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


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