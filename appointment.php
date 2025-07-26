<?php
session_start();

// Correct login check using 'email'
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}
$selected_doctor = isset($_GET['doctor']) ? htmlspecialchars($_GET['doctor']) : 'Dr. Sharma';

// Database connection
$conn = new mysqli("localhost", "root", "", "mediconnect");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $doctor = $_POST['doctor'];
  $date = $_POST['date'];
  $time = $_POST['time'];

  // Get user email from session
  $user_email = $_SESSION['user'];

  // Insert into appointments using email (or join later with user table if needed)
  $sql = "INSERT INTO appointments (doctor_name, appointment_date, appointment_time, user_email)
          VALUES ('$doctor', '$date', '$time', '$user_email')";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Appointment booked successfully!');</script>";
  } else {
    echo "<script>alert('Error: " . $conn->error . "');</script>";
  }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Appointment - MediConnect</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
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
        <li class="nav-item"><a class="nav-link" href="admin-dashboard.php">Admin</a></li>
      </ul>
      
      <div class="d-flex">
        <?php if (!isset($_SESSION['user'])): ?>
          <a href="login.php" class="btn btn-outline-primary me-2">Login</a>
          <a href="signup.php" class="btn btn-primary">Sign Up</a>
        <?php else: ?>
          <span class="me-3 mt-2">Welcome, <?= htmlspecialchars($_SESSION['user']) ?></span>
          <a href="logout.php" class="btn btn-danger">Logout</a>
        <?php endif; ?>
      </div>

    </div>
  </div>
</header>


<div class="container my-5">
  <h2 class="text-center mb-4">📅 Book Appointment</h2>
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card p-4 shadow-sm">
        <form method="POST" action="">
          <div class="mb-3">
            <label for="doctor" class="form-label">Doctor:</label>
            <input type="text" class="form-control" id="doctor" name="doctor" value="<?= $selected_doctor ?>" readonly>

          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Date:</label>
            <input type="date" class="form-control" id="date" name="date" required>
          </div>
          <div class="mb-3">
            <label for="time" class="form-label">Time:</label>
            <input type="time" class="form-control" id="time" name="time" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Submit Booking</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
