<?php
$host = 'localhost';
$user = 'root';
$password = 'r00t*marS';
$dbname = 'equipment-company';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
  die("Ошибка подключения: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
