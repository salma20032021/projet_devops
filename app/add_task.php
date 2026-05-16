<?php
session_start();
include "DB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    mysqli_query($conn, "INSERT INTO tasks (title, description)
    VALUES ('$title', '$description')");

    $_SESSION['message'] = "Tache ajoutee !";

    header("Location: index.php");
    exit();
}
?>