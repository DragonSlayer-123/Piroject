<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jutta Sansaar</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Jutta Sansaar</h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="products.php">Shop</a>
      <a href="cart.php">Cart</a>
      <a href="login.php">Login</a>
    </nav>
  </header>

  <main>
    <section class="hero">
      <h2>Step into Style</h2>
      <p>Find your perfect pair at Jutta Sansaar</p>
    </section>

    <section class="featured">
      <h3>Featured Shoes</h3>
      <?php include 'fetch_featured.php'; ?>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Jutta Sansaar. All rights reserved.</p>
  </footer>
</body>
</html>
