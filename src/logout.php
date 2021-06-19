<?php
require_once "./class/user.php";
$user = user::s_userLogged();

unset($_SESSION["user"]);
unset($user);


$_SESSION["loggedout"] = true;

header("Location: ./../index.php");
exit();