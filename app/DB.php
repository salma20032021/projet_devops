<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "todo_db";

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Erreur : " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");
?>