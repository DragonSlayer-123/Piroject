<!-- admin.php -->
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
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #333;
      color: #fff;
      padding: 1rem;
      text-align: center;
    }
    main {
      padding: 2rem;
    }
    .card {
      background-color: #fff;
      padding: 1rem;
      margin: 1rem auto;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      max-width: 800px;
    }
    h2 {
      color: #333;
    }
    a.logout {
      float: right;
      color: #fff;
      text-decoration: underline;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: left;
    }
  </style>
</head>
<body>
  <header>
    <h1>Admin Dashboard <a href="logout.php" class="logout">Logout</a></h1>
  </header>
  <main>
    <div class="card">
      <h2>All Users</h2>
      <?php
      $users = mysqli_query($conn, "SELECT id, name, email, is_admin FROM users");
      echo "<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>";
      while ($row = mysqli_fetch_assoc($users)) {
        $role = $row['is_admin'] ? 'Admin' : 'Customer';
        echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['email']}</td><td>$role</td></tr>";
      }
      echo "</table>";
      ?>
    </div>
  </main>
</body>
</html>
