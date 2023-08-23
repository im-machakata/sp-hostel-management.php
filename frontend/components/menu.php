<nav class="navbar navbar-expand-lg navbar-light border-bottom border-success shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/"><span class="text-success">Hostel</span><span class="text-muted">ia</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link<?= url_active('/') ?>" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= url_active('') ?>" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= url_active('') ?>" href="#">Pricing</a>
                </li>
                <?php if (session('UserID')) : ?>
                    <li class="nav-item">
                        <a class="nav-link<?= url_active('/logout.php') ?>" href="/logout.php">Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>