<?php
include 'db.php';
session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $payment_method = $_POST['payment_method'];
  $user_id = $_SESSION['user_id'] ?? 0;

  $sql = "INSERT INTO orders (user_id, name, phone, address, payment_method, status) 
          VALUES ('$user_id', '$name', '$phone', '$address', '$payment_method', 'Pending')";
  if (mysqli_query($conn, $sql)) {
    $message = "Order placed successfully!";
  } else {
    $message = "Error placing order: " . mysqli_error($conn);
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Checkout - Jutta Sansaar</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('https://cloudfront-us-east-2.images.arcpublishing.com/reuters/NKYZ3DCPBRMHVL3LP65XEHONXA.jpg') no-repeat center center/cover;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    header, footer {
      background: #222;
      color: white;
      padding: 1.5rem 2rem;
    }

    header {
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 2px 6px rgba(0,0,0,0.4);
    }

    .container {
      max-width: 1200px;
      margin: auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    nav a {
      color: #ddd;
      text-decoration: none;
      margin: 0 10px;
      padding: 6px 10px;
      border-radius: 4px;
    }

    nav a:hover {
      background: #f39c12;
      color: #222;
    }

    .checkout-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 3rem 1rem;
    }

    .checkout-form {
      background: white;
      padding: 2rem;
      border-radius: 12px;
      max-width: 500px;
      width: 100%;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
    }

    .checkout-form h2 {
      text-align: center;
      margin-bottom: 1rem;
    }

    .form-group {
      margin-bottom: 1.2rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      color: #333;
    }

    .form-group input, .form-group textarea, .form-group select {
      width: 100%;
      padding: 0.8rem;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    .btn {
      width: 100%;
      background-color: #ff7e5f;
      color: white;
      border: none;
      padding: 0.9rem;
      font-size: 1rem;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .btn:hover {
      background-color: #eb6a48;
    }

    .khalti-button {
      background: #5c2d91;
      margin-top: 10px;
    }

    .message {
      text-align: center;
      color: green;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
  <header>
    <div class="container">
      <h1>👟 Jutta Sansaar</h1>
      <nav>
        <a href="index.php">Home</a>
        <a href="products.php">Shop</a>
        <a href="cart.php">Cart</a>
        <a href="checkout.php">Checkout</a>
        <a href="login.php">Login</a>
      </nav>
    </div>
  </header>

  <div class="checkout-container">
    <form method="POST" class="checkout-form">
      <h2>Checkout</h2>
      <?php if ($message): ?>
        <p class="message"><?= $message ?></p>
      <?php endif; ?>

      <div class="form-group">
        <label for="name">Full Name</label>
        <input name="name" id="name" required />
      </div>

      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input name="phone" id="phone" required />
      </div>

      <div class="form-group">
        <label for="address">Delivery Address</label>
        <textarea name="address" id="address" rows="3" required></textarea>
      </div>

      <div class="form-group">
        <label for="payment_method">Payment Method</label>
        <select name="payment_method" id="payment_method" required>
          <option value="Cash on Delivery">Cash on Delivery</option>
          <option value="Khalti">Khalti</option>
        </select>
      </div>

      <button type="submit" class="btn">Place Order</button>

      <!-- Khalti Payment Button -->
      <button type="button" class="btn khalti-button" id="khalti-btn">Pay with Khalti</button>
    </form>
  </div>

  <footer>
    <p>&copy; 2025 Jutta Sansaar. All rights reserved.</p>
  </footer>

  <!-- Khalti Script -->
  <script src="https://khalti.com/static/khalti-checkout.js"></script>
  <script>
    var config = {
        "publicKey": "test_public_key_dc74cfcc2d1e4fd196f1781325a6d8ec", // Replace with live key on production
        "productIdentity": "1234567890",
        "productName": "Jutta Order",
        "productUrl": "http://localhost/products.php",
        "paymentPreference": ["KHALTI"],
        "eventHandler": {
            onSuccess(payload) {
                alert("Khalti Payment Success!\nTransaction ID: " + payload.idx);
                // You can use AJAX here to save transaction to DB
            },
            onError(error) {
                alert("Khalti Payment Failed");
            },
            onClose() {
                console.log('widget is closing');
            }
        }
    };
    var checkout = new KhaltiCheckout(config);
    document.getElementById("khalti-btn").onclick = function() {
        checkout.show({amount: 50000}); // In paisa (e.g., Rs. 500)
    }
  </script>
</body>
</html>
