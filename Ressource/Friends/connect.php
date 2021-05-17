<?php
session_start();
require "db.php";
if (!empty($_POST["username"])) {
    $query = $db->prepare("SELECT  username FROM user WHERE username=:username AND password = :password");
    $query->execute([
        "username" => $_POST["username"],
        "password" => $_POST["password"]
    ]);

    $data = $query->fetch();
    // var_dump($data);
    if ($data) {
        $_SESSION['user'] = $_POST['username'];
        header('location:user.php');
    } else {
        header('location:index.php');
    }
} else {
    header('location:index.php');
}
