<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "manga_store";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");
?>