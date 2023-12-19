<?php
$host     = "localhost";
$username = "root";
$password = "";
$dbname   = "Reservas";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Erro de ligação: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");
