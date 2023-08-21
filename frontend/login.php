 
<?php
require_once __DIR__."/../backend/Controllers/LoginController.php";
$controller = new LoginController();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <title>Login - Hostel Management System</title>
</head>
<body>
    <main class="container-fluid">
        <h1 class="text-center pt-4">Hostels Management System</h1>
        <p class="lead text-center">The ultimate solution for all students looking for accomadation.</p>

        <section class="login row jumbotron justify-content-center">
            <div class="col-6 my-2 border p-3 p-lg-4 shadow-sm rounded">
                <form action="/login.php" method="post">
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" placeholder="Username" id="username" name="username" required>
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" placeholder="Password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Login</button>
                </form>
            </div>
        </section>
    </main>    

<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>