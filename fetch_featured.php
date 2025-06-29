<?php
include 'db.php';

$sql = "SELECT * FROM products ORDER BY id DESC LIMIT 4";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    // Sanitize and format data
    $id = (int)$row['id'];
    $name = htmlspecialchars($row['name'], ENT_QUOTES);
    $price = number_format($row['price'], 2);
    $image = htmlspecialchars($row['image'], ENT_QUOTES);

    echo "<div class='carousel-item'>
            <img src='images/{$image}' alt='{$name}' />
            <h4>{$name}</h4>
            <p class='price'>₹{$price}</p>
            <button onclick='addToCart({$id})'>Add to Cart</button>
          </div>";
}
?>
