<!-- cart.php -->
<?php
include 'db.php';
session_start();
$user_id = $_SESSION['user_id'] ?? 1; // default to user 1 for demo
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cart - Jutta Sansaar</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>Your Cart</h1>
    <a href="products.php">Continue Shopping</a>
  </header>
  <main>
    <table>
      <tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th></tr>
      <?php
      $sql = "SELECT p.name, p.price, c.quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = $user_id";
      $result = mysqli_query($conn, $sql);
      $grand_total = 0;
      while ($row = mysqli_fetch_assoc($result)) {
        $total = $row['price'] * $row['quantity'];
        $grand_total += $total;
        echo "<tr><td>{$row['name']}</td><td>{$row['quantity']}</td><td>\${$row['price']}</td><td>\${$total}</td></tr>";
      }
      echo "<tr><td colspan='3'>Grand Total</td><td>\${$grand_total}</td></tr>";
      ?>
    </table>
  </main>
</body>
</html>