<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
  header("Location: login.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $desc = $_POST['description'];
  $price = $_POST['price'];
  $img = $_POST['image_url'];

  $sql = "INSERT INTO products (name, description, price, image_url)
          VALUES ('$name', '$desc', '$price', '$img')";
  mysqli_query($conn, $sql);
}

header("Location: admin.php");
exit();
