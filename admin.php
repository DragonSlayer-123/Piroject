<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Jutta Sansaar</title>
  <!-- <link rel="stylesheet" href="styles.css"> -->
  <style>
    body { font-family: Arial; background: #f4f4f4; padding: 0; margin: 0; }
    header { background: #333; color: white; padding: 1rem; text-align: center; }
    main { padding: 2rem; }
    .card { background: white; padding: 1rem; margin-bottom: 2rem; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    h2 { margin-top: 0; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
    .logout { float: right; color: white; text-decoration: underline; }
    button { margin: 2px; }
  </style>
</head>
<body>
<header>
  <h1>Admin Dashboard <a href="logout.php" class="logout">Logout</a></h1>
</header>

<main>

<!-- Product Adder -->
<div class="card">
  <h2>Add New Product</h2>
  <form method="POST" action="add_product.php">
    <input type="text" name="name" placeholder="Product Name" required><br><br>
    <textarea name="description" placeholder="Description"></textarea><br><br>
    <input type="number" step="0.01" name="price" placeholder="Price" required><br><br>
    <input type="text" name="image_url" placeholder="Image URL"><br><br>
    <button type="submit">Add Product</button>
  </form>
</div>

<!-- Orders Table -->
<div class="card">
  <h2>Customer Orders</h2>
  <?php
  $orders = mysqli_query($conn, "
    SELECT orders.id, users.name AS customer, products.name AS product,
           orders.quantity, orders.status
    FROM orders
    JOIN users ON orders.user_id = users.id
    LEFT JOIN products ON orders.product_id = products.id
    ORDER BY orders.created_at DESC
  ");

  echo "<table><tr><th>Order ID</th><th>Customer</th><th>Product</th><th>Qty</th><th>Status</th><th>Actions</th></tr>";

  while ($row = mysqli_fetch_assoc($orders)) {
    $status = $row['status'];
    echo "<tr>
      <td>{$row['id']}</td>
      <td>{$row['customer']}</td>
      <td>" . ($row['product'] ?? 'N/A') . "</td>
      <td>{$row['quantity']}</td>
      <td>$status</td>
      <td>
        <form method='POST' action='update_order.php'>
          <input type='hidden' name='order_id' value='{$row['id']}'>
          <button name='action' value='accept' " . ($status == 'Accepted' ? 'disabled' : '') . ">Accept</button>
          <button name='action' value='reject' " . ($status == 'Rejected' ? 'disabled' : '') . ">Reject</button>
        </form>
      </td>
    </tr>";
  }

  echo "</table>";
  ?>
</div>

</main>
</body>
</html>
