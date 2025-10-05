<?php
require 'config.php';

function redirectWithMessage($message, $type = 'error')
{
  echo '<script>';
  echo 'sessionStorage.setItem("toastMessage", ' . json_encode($message) . ');';
  echo 'sessionStorage.setItem("toastType", ' . json_encode($type) . ');';
  echo 'window.location.href = "form.html";';
  echo '</script>';
  exit();
}

$equipment_name = trim($_POST['equipment_name'] ?? '');
$rental_period_days = trim($_POST['rental_period_days'] ?? '');
$renter_name = trim($_POST['renter_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');

if ($equipment_name === '') {
  redirectWithMessage("Введите название оборудования.", 'error');
}
if ($rental_period_days === '' || !is_numeric($rental_period_days) || (int)$rental_period_days <= 0) {
  redirectWithMessage("Введите корректный период аренды в днях.", 'error');
}
if ($renter_name === '') {
  redirectWithMessage("Введите имя арендатора.", 'error');
}
if ($phone === '') {
  redirectWithMessage("Введите телефон.", 'error');
}
if (!preg_match('/^\+?[0-9\s()-]{7,100}$/', $phone)) {
  redirectWithMessage("Ошибка отправления: телефон содержит недопустимые символы.", 'error');
}

$stmt = $conn->prepare("INSERT INTO `equipment-company-form` (equipment_name, rental_period_days, renter_name, phone) VALUES (?, ?, ?, ?)");
if (!$stmt) {
  redirectWithMessage("Ошибка подготовки запроса: " . $conn->error, 'error');
}

$stmt->bind_param("siss", $equipment_name, $rental_period_days, $renter_name, $phone);

if ($stmt->execute()) {
  redirectWithMessage("Данные успешно сохранены!", 'success');
} else {
  redirectWithMessage("Ошибка выполнения запроса: " . $stmt->error, 'error');
}

$stmt->close();
$conn->close();
