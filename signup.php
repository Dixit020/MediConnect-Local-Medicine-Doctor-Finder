<?php
// Handle form submission
$alert = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = new mysqli("localhost", "root", "", "mediconnect");

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = $_POST['role'];

  // ✅ Table name should be 'users'
  $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $check->bind_param("s", $email);
  $check->execute();
  $res = $check->get_result();

  if ($res->num_rows > 0) {
    $alert = 'Email already registered. Please login.';
  } else {
    // ✅ Table name corrected here too
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    if ($stmt->execute()) {
      $alert = "Signup successful! Please login.";
    } else {
      $alert = "Signup failed. Please try again.";
    }
    $stmt->close();
  }

  $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Signup - MediConnect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
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

  <!-- Alert -->
  <?php if ($alert): ?>
    <div class="container mt-4">
      <div class="alert alert-info text-center"><?= $alert ?></div>
    </div>
  <?php endif; ?>

  <!-- Signup Form -->
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow p-4">
          <h3 class="text-center mb-4">📝 Signup</h3>
          <form action="" method="POST">
            <div class="mb-3">
              <label for="signupName" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="signupName" name="name" placeholder="Enter your name" required>
            </div>
            <div class="mb-3">
              <label for="signupEmail" class="form-label">Email address</label>
              <input type="email" class="form-control" id="signupEmail" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
              <label for="signupPassword" class="form-label">Password</label>
              <input type="password" class="form-control" id="signupPassword" name="password" placeholder="Enter password" required>
            </div>
            <div class="mb-4">
              <label for="signupRole" class="form-label">Select Role</label>
              <select class="form-select" id="signupRole" name="role" required>
                <option value="">-- Choose Role --</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <button type="submit" class="btn btn-success w-100">✅ Create Account</button>
          </form>
          <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
