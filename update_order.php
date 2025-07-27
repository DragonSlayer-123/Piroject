<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
  header("Location: login.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $order_id = $_POST['order_id'];
  $action = $_POST['action'];

  if ($action === 'accept') {
    $status = 'Accepted';
  } elseif ($action === 'reject') {
    $status = 'Rejected';
  } else {
    $status = 'Pending';
  }

  $query = "UPDATE orders SET status='$status' WHERE id=$order_id";
  mysqli_query($conn, $query);
}
header("Location: admin.php");
exit();
