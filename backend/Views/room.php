<div class="card border-success">
    <div class="ratio ratio-16x9">
        <img src="<?= $image_url ?? ('/assets/images/demo.jpg') ?>" class="card-img-top img-fluid" alt="<?= $name ?> Image">
    </div>
    <div class="card-body">
        <div class="clearfix mb-1">
            <div class="text-dark h5 badge bg-warning mb-2">
                USD $<?= number_format($cost, 2) ?>
            </div>
            <?php if (session('UserType') == 'Admin' && Request::isUrl('/manage-rooms.php')) : ?>
                <div class="text-dark h5 badge bg-info mb-2">
                    EDIT ROOM
                </div>
                <div class="h5 badge bg-danger mb-2 float-end">
                    DELETE
                </div>
            <?php endif; ?>
        </div>
        <h2 class="card-title"><?= $name ?></h2>
        <p class="card-text"><?= $description ?></p>
        <?php if ($is_booked) : ?>
            <a href="/book-room.php?id=<?= $id ?>" class="btn btn-success disabled">Room Is Booked</a>
        <?php else : ?>
            <a href="/book-room.php?id=<?= $id ?>" class="btn btn-outline-success">Book This Room</a>
        <?php endif; ?>
    </div>
</div>