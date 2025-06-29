<?php
include 'db.php';

$sql = "SELECT * FROM products ORDER BY id DESC LIMIT 4";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='product'>
            <img src='images/{$row['image']}' alt='{$row['name']}' style='width:100%; height:auto;'>
            <h4>{$row['name']}</h4>
            <p>\${$row['price']}</p>
            <a href='products.php'>Buy Now</a>
          </div>";
}
?>
