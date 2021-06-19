<?php
require_once "src/class/user.php";

$user = user::s_userLogged();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akademia IT Recruitment</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-light bg-light shadow-sm">
    <a href="main.php" class="navbar-brand mx-3">AkademiaIT Recruitment Task</a>
    <div>
        <a href="holiday.php" class="btn btn-primary mx-3">I want to go holidays </a>
        <a href="src/logout.php" class="btn btn-dark mx-3">Log out </a>
    </div>
</nav>

<?php
if (isset($_SESSION['holiday'])) {

    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Hurray! </strong>Your application has been proceeded successfully ⛵🌴. You applied for ' . $_SESSION["holiday"] . ' day(s)
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    unset($_SESSION['holiday']);
}
?>

<main class="container d-flex justify-content-center align-items-center min-vh-100 text-center">
    <section>
        <h1 class="h1 font-weight-normal">
            <?php echo "hello {$user->getName()} {$user->getSurname()}"; ?>
        </h1>
        <h2 class="h5 font-weight-normal">
            <?php echo "Your gender is: {$user->getSex()}"; ?>
        </h2>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>