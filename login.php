<!-- login.php -->
<?php
include 'db.php';
session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $role = $_POST['role'];

  $sql = "SELECT * FROM users WHERE email = '$email'";
  $result = mysqli_query($conn, $sql);
  $user = mysqli_fetch_assoc($result);

  if ($user && password_verify($password, $user['password'])) {
    if (($role === 'admin' && $user['is_admin']) || ($role === 'customer' && !$user['is_admin'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['is_admin'] = $user['is_admin'];
      header("Location: index.php");
      exit();
    } else {
      $message = 'Role mismatch. Please select the correct login role.';
    }
  } else {
    $message = 'Invalid email or password';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Jutta Sansaar</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      background: linear-gradient(135deg, #ff7e5f, #feb47b);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .login-container {
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 400px;
    }
    .login-container h2 {
      text-align: center;
      margin-bottom: 1rem;
      color: #333;
    }
    .form-group {
      margin-bottom: 1rem;
    }
    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      color: #555;
    }
    .form-group input,
    .form-group select {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
    }
    .btn {
      width: 100%;
      background-color: #ff7e5f;
      border: none;
      padding: 0.75rem;
      font-size: 1rem;
      color: white;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .btn:hover {
      background-color: #eb6a48;
    }
    .error {
      color: red;
      text-align: center;
      margin-bottom: 1rem;
    }
    .signup-link {
      text-align: center;
      margin-top: 1rem;
    }
    .signup-link a {
      color: #ff7e5f;
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Login to Jutta Sansaar</h2>
    <?php if ($message): ?>
      <p class="error"><?= $message ?></p>
    <?php endif; ?>
    <form method="POST">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
      </div>
      <div class="form-group">
        <label for="role">Login as</label>
        <select name="role" id="role" required>
          <option value="customer">Customer</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <button type="submit" class="btn">Login</button>
    </form>
    <div class="signup-link">
      <p>Don't have an account? <a href="register.php">Sign up</a></p>
    </div>
  </div>
</body>
</html>
