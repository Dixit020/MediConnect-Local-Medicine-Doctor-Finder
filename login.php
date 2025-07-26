<?php
session_start();
require_once 'db.php';

$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
  $_SESSION['user'] = $user['email'];
  $_SESSION['role'] = $user['role']; // ✅ Add this line to store the role
  header("Location: index.php");
  exit;
} else {
      $login_error = "Invalid password.";
    }
  } else {
    $login_error = "User not found.";
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - MediConnect</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- External CSS (already in your project) -->
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<!-- Navbar -->
<header class="navbar navbar-expand-lg navbar-light bg-light shadow p-3">
  <div class="container">
    <a class="navbar-brand text-primary fw-bold" href="#">MediConnect</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="doctors.php">Doctors</a></li>
        <li class="nav-item"><a class="nav-link" href="pharmacy.php">Pharmacy</a></li>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
  <li class="nav-item"><a class="nav-link" href="admin-dashboard.php">Admin</a></li>
<?php endif; ?>

      </ul>
      <div class="d-flex">
        <a href="login.php" class="btn btn-outline-primary me-2">Login</a>
        <a href="signup.php" class="btn btn-primary">Sign Up</a>
      </div>
    </div>
  </div>
</header>

<!-- Login Form Section -->
<div class="container">
  <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-12 col-sm-8 col-md-6 col-lg-4">
      <div class="card p-4 shadow">
        <h2 class="text-center text-primary mb-3">Login</h2>

        <?php if (!empty($login_error)): ?>
          <div class="alert alert-danger text-center"><?php echo $login_error; ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter email" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter password" required />
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
        </form>

        <div class="text-center mt-3">
          <p>Don't have an account? <a href="signup.php">Signup</a></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
