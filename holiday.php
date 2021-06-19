<?php
require_once "src/class/user.php";
require_once "src/class/application.php";

$user = user::s_userLogged();

if (isset($_POST["type"])) {


    try {
        $application = new application();
        $application->setType(filter_input(INPUT_POST, "type", FILTER_SANITIZE_STRING));
        $application->setDateFrom(filter_input(INPUT_POST, "dateFrom", FILTER_SANITIZE_STRING));
        $application->setDateTo(filter_input(INPUT_POST, "dateTo", FILTER_SANITIZE_STRING));

        $application->checkDates();

        $application->setComment(filter_input(INPUT_POST, "comment", FILTER_SANITIZE_STRING));
       // print_r($application);

        require_once "src/fileUpload.php";
        $application->setFile(uploadFile());

        if ($application->proceed($user->getLogin())) {

            $_SESSION["holiday"] = $application->workingDays();
            header("Location: main.php");
        }


    } catch (Exception $e) {
        //print_r($e->getMessage());
        $_SESSION['upload_error'] = $e->getMessage();
    }
}
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
    <link href="styles/custom.css" rel="stylesheet" type="text/css">
</head>
<body>

<nav class="navbar navbar-light bg-light shadow-sm">
    <a href="main.php" class="navbar-brand mx-3">AkademiaIT Recruitment Task</a>
    <div>
        <a href="src/logout.php" class="btn btn-dark mx-3">Log out </a>
    </div>
</nav>

<?php
if (isset($_SESSION['upload_error'])) {

    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error: </strong> ' . $_SESSION["upload_error"] . '.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    unset($_SESSION['upload_error']);
}
?>

<main class="container d-flex justify-content-center align-items-center min-vh-100">

    <form method="post" enctype="multipart/form-data"
          class="d-flex justify-content-center flex-column shadow-sm p-5 rounded">
        <h1 class="h1 font-weight-normal">Holiday Form</h1>

        <div class="input-group my-2">
            <label class="input-group-text" for="type">type</label>

            <select name="type" id="type" class="form-select">
                <option>regular holiday</option>
                <option>vacation on request</option>
                <option>unpaid leave</option>
            </select>
        </div>

        <div class="input-group my-2">
            <label class="input-group-text" for="dateFrom">from</label>
            <input type="date" name="dateFrom" id="dateFrom" placeholder="date from" class="form-control">
        </div>

        <div class="input-group my-2">
            <label class="input-group-text" for="dateTo">to</label>
            <input type="date" name="dateTo" id="dateTo" placeholder="date to" class="form-control">
        </div>

        <div class="custom-file my-2">
            <input type="file" accept=".pdf, .jpg" name="document" id="document"
                   class="custom-file-input" required>
            <script>
              document.getElementById("document").addEventListener('change', function () {
                document.getElementById("fileName").textContent = document.getElementById("document").files[0].name;
                console.log(document.getElementById("document").files[0].name);
              });
            </script>
            <label class="custom-file-label" for="document" id="fileName">Choose File</label>

        </div>

        <div class="input-group my-2">
            <textarea name="comment" id="comment" placeholder="comment" class="form-control"></textarea>
        </div>

        <input type="submit" value="Send application" class="btn btn-primary btn-block">
    </form>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>