<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop - Jutta Sansaar</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f8f8f8;
    }
    header {
      background: #007bff;
      color: white;
      padding: 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header h1 {
      margin: 0;
    }
    header a {
      color: white;
      text-decoration: none;
      font-weight: bold;
    }
    .featured {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
      padding: 2rem;
    }
    .product {
      background: white;
      border-radius: 10px;
      padding: 1rem;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    .product img {
      max-width: 100%;
      height: 200px;
      object-fit: contain;
      margin-bottom: 1rem;
    }
    .product h4 {
      margin: 0.5rem 0;
      color: #333;
    }
    .product p {
      color: #28a745;
      font-weight: bold;
    }
    .product input[type='number'] {
      width: 60px;
      padding: 5px;
      margin: 0.5rem 0;
    }
    .product button {
      background: #007bff;
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 5px;
      cursor: pointer;
    }
    .product button:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>
  <header>
    <h1>Shop Shoes</h1>
    <a href="index.php">Home</a>
  </header>
  <main class="featured">
    <?php
    // Sample fallback products (if DB is empty)
    $fallback = [
      ['name' => 'Black Sports Shoes', 'price' => 1999, 'image' => 'black_sports.jpg'],
      ['name' => 'Classic Leather Loafers', 'price' => 2499, 'image' => 'loafers.jpg'],
      ['name' => 'Casual White Sneakers', 'price' => 1799, 'image' => 'sneakers.jpg'],
      ['name' => 'High-Top Basketball Shoes', 'price' => 2899, 'image' => 'basketball.jpg']
    ];

    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) === 0) {
      // Insert fallback products if table is empty
      foreach ($fallback as $item) {
        $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $item['name'], $item['price'], $item['image']);
        $stmt->execute();
      }
      // Rerun query
      $result = mysqli_query($conn, $sql);
    }

    while ($row = mysqli_fetch_assoc($result)) {
      $id = htmlspecialchars($row['id']);
      $name = htmlspecialchars($row['name']);
      $price = number_format($row['price'], 2);
      $image = htmlspecialchars($row['image']);
      echo "<div class='product'>
              <img src='images/{$image}' alt='{$name}'>
              <h4>{$name}</h4>
              <p>₹{$price}</p>
              <form method='POST' action='add_to_cart.php'>
                <input type='hidden' name='product_id' value='{$id}'>
                <input type='number' name='quantity' value='1' min='1'>
                <button type='submit'>Add to Cart</button>
              </form>
            </div>";
    }
    ?>
  </main>
</body>
</html>
