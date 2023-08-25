<?php
require "../backend/Controllers/RoomsController.php";
require '../backend/Models/Rooms.php';
require '../backend/Models/Images.php';
require '../backend/Models/Users.php';

$controller = new RoomsController();
$rooms = new Rooms();
$images = new Images();
$users = new Users();

$user = $users->find(session('UserID'))->getRow();
$images = $images->getRoomImages($controller->request->get('id'));
$room = $rooms->find($controller->request->get('id'))->getRow();

render_component('head', ['title' => 'Book Room']);
?>

<body>
    <?php render_component('menu'); ?>
    <main>
        <?php if ($room) : ?>
            <?php if ($images) : ?>
                <section class="ratio ratio-16x9 room-image border-top border-success input-fix" style="max-height: 70vh;">
                    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($images as $image) : ?>
                                <div class="carousel-item active">
                                    <img src="<?= $image['source'] ?>" class="d-block w-100" alt="<?= $image['description'] ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </section>
            <?php else : ?>
                <section class="ratio ratio-16x9 room-image border-top border-success input-fix" style="max-height: 50vh;background: url(<?= $room['image_url'] ?? '/assets/images/demo.jpg' ?>) no-repeat; background-size: cover; background-position: center;"></section>
            <?php endif; ?>
            <div class="container-fluid">
                <section class="px-0 container-lg">
                    <?php render_component('header', ['page' => 'Book']); ?>
                    <div class="row justify-content-center mt-2">
                        <!-- Errors Layouts -->
                        <?php if ($controller->hasErrors()) : ?>
                            <div class="col-11 col-lg-12 px-0">
                                <div class="alert alert-danger text-lg-center mt-1 mb-4">
                                    <?= $controller->getLastError() ?>
                                </div>
                            </div>
                            <div class="col-12"></div>
                        <?php endif;
                        if (!$controller->hasErrors() && $controller->request->isPost()) : ?>
                            <div class="col-11 col-lg-12 px-0">
                                <div class="alert alert-success text-lg-center mt-1 mb-4">
                                    Payment instructions have been sent to your email.
                                </div>
                            </div>
                            <div class="col-12"></div>
                        <?php endif; ?>
                        <div class="col-md-5 col-lg-4 order-md-last">
                            <h4 class="text-dark mb-3">
                                Room Details
                            </h4>
                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between border-success lh-sm">
                                    <div>
                                        <h6 class="my-0"><?= $room['name'] ?></h6>
                                        <small class="text-muted"><?= $room['description'] ?></small>
                                    </div>
                                    <span class="text-muted">$<?= number_format($room['cost'], 2)  ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between border-success">
                                    <span>Total (USD)</span>
                                    <strong>$<?= number_format($room['cost'], 2) ?></strong>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-7 col-lg-8">
                            <h4 class="mb-3">Billing address</h4>
                            <form method="post" action="/book-room.php?id=<?= $controller->request->get('id') ?>">
                                <div class="row g-3 mb-4">
                                    <div class="col-sm-6">
                                        <label for="first-name" class="form-label">First name</label>
                                        <input type="text" class="form-control" id="firstName" placeholder="Names" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="lastName" class="form-label">Last name</label>
                                        <input type="text" class="form-control" id="lastName" placeholder="Surname" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" placeholder="Username" value="<?= $user['username'] ?>" readonly>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="you@example.com" required>
                                    </div>

                                    <div class="col-12">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
                                    </div>
                                    <input type="hidden" name="room-id" value="<?= $controller->request->get('id') ?>">
                                </div>

                                <button class="w-100 btn btn-success btn-lg mt-2" type="submit">Send Instructions</button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        <?php else : ?>
            <div class="container-fluid">
                <?php render_component('header', ['page' => 'Book']); ?>
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-6">
                        <p class="alert alert-danger border-danger text-lg-center">We do not know anything about the room you're looking for</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>
    <?php render_component('footer'); ?>
</body>

</html>