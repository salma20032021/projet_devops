<?php

$conn = mysqli_connect(
    "db",
    "task_user",
    "task_password",
    "tasks"
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>