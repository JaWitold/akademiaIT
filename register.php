<?php

session_start();
require_once "src/class/user.php";

//user is logged already
if (isset($_SESSION["user"])) {
    header("Location: main.php");
    exit();
}

//if form was submitted
if (isset($_POST['login'])) {
    try {
        $user = new user();

        $user->setLogin(filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRING));
        $user->setPassword(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING));
        $user->setName(filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING));
        $user->setSurname(filter_input(INPUT_POST, "surname", FILTER_SANITIZE_STRING));
        $user->setSex(filter_input(INPUT_POST, "gender", FILTER_SANITIZE_STRING));

        if (strcmp($user->getPassword(), $_POST["repeatPassword"]) != 0) {
            throw new Exception("Passwords must be identical");
        }

        $user->addToDB();

        session_start();
        $_SESSION["registered"] = true;
        header("Location: index.php");
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
    //print_r($user);

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
</head>
<body>

<?php
if (isset($error)) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Uups! </strong>' . $error . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    unset($error);
}
?>

<main class="container d-flex justify-content-center align-items-center flex-column min-vh-100">
    <div class="row">
        <div class=" d-flex justify-content-center align-items-center flex-column shadow-sm p-5 rounded">
            <form method="POST" class="d-flex justify-content-center flex-column">
                <h1 class="h1 font-weight-normal">register</h1>
                <div class="input-group my-2">
                    <label class="input-group-text" for="login">login</label>
                    <input type="text" name="login" id="login" placeholder="login" class="form-control">
                </div>

                <div class="input-group my-2">
                    <label class="input-group-text" for="password">password</label>
                    <input type="password" name="password" id="password" placeholder="password" class="form-control">
                </div>

                <div class="input-group my-2">
                    <label class="input-group-text" for="repeatPassword">repeat password</label>
                    <input type="password" name="repeatPassword" id="repeatPassword" placeholder="password"
                           class="form-control">
                </div>

                <div class="input-group my-2">
                    <label class="input-group-text" for="name">name</label>
                    <input type="text" name="name" id="name" placeholder="name" class="form-control">
                </div>

                <div class="input-group my-2">
                    <label class="input-group-text" for="surname">surname</label>
                    <input type="text" name="surname" id="surname" placeholder="surname" class="form-control">
                </div>

                <div class="input-group my-2">
                    <label class="input-group-text" for="gender">gender</label>

                    <select name="gender" id="gender" class="form-select">
                        <option>Male</option>
                        <option>Female</option>
                        <option>Non binary</option>
                    </select>
                </div>

                <input type="submit" value="register" class="btn btn-primary btn-block my-2">

            </form>
            <section class="col-12 d-flex justify-content-center flex-column text-center">
                <h2 class="h4">or login if You have an account</h2>
                <a href="index.php" class="btn btn-block btn-link">log in</a>
            </section>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>