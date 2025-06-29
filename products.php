<!-- products.php -->
<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shop - Jutta Sansaar</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>Shop Shoes</h1>
    <a href="index.php">Home</a>
  </header>
  <main class="featured">
    <?php
    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<div class='product'>
              <img src='images/{$row['image']}' alt='{$row['name']}'>
              <h4>{$row['name']}</h4>
              <p>\${$row['price']}</p>
              <form method='POST' action='add_to_cart.php'>
                <input type='hidden' name='product_id' value='{$row['id']}'>
                <input type='number' name='quantity' value='1' min='1'>
                <button type='submit'>Add to Cart</button>
              </form>
            </div>";
    }
    ?>
  </main>
</body>
</html>