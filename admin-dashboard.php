<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - MediConnect</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .sidebar {
      background-color: #f8f9fa;
      padding: 15px;
      height: 100vh;
    }

    @media (max-width: 768px) {
      .sidebar {
        position: absolute;
        z-index: 1000;
        width: 250px;
        height: 100%;
        left: -250px;
        top: 0;
        transition: left 0.3s;
      }

      .sidebar.show {
        left: 0;
      }

      .toggle-btn {
        margin: 15px;
      }
    }

    .form-container {
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    h3 {
      color: #2c3e50;
      font-weight: bold;
    }
  </style>
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


<!-- PHP Doctor Form Logic -->
<?php
$conn = new mysqli("localhost", "root", "", "mediconnect");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $specialty = $_POST['specialty'];
  $location = $_POST['location'];
  $contact = $_POST['contact'];
  $email = $_POST['email'];
  $image = $_POST['image_url'];

  $sql = "INSERT INTO doctors (name, specialization, city, contact, email, image) VALUES ('$name', '$specialty', '$location', '$contact', '$email', '$image')";
  if ($conn->query($sql) === TRUE) {
    echo "<div class='alert alert-success text-center m-3'>✅ Doctor added successfully.</div>";
  } else {
    echo "<div class='alert alert-danger text-center m-3'>❌ Error: " . $conn->error . "</div>";
  }
}
?>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar Toggle -->
    <div class="d-block d-md-none toggle-btn">
      <button class="btn btn-primary" onclick="toggleSidebar()">☰ Menu</button>
    </div>

    <!-- Sidebar -->
    <div class="col-md-3 sidebar d-none d-md-block" id="sidebar">
      <h4 class="fw-bold text-primary">📌 Admin Panel</h4>
      <hr>
      <a href="#" class="d-block mb-2">➤ Doctors</a>
      <a href="add_pharmacy.php" class="d-block mb-2 text-success">➤ Add Pharmacy</a>
      <a href="view_appointments.php" class="d-block mb-2 ms-3">➤ Appointments</a>
    </div>

    <!-- Sidebar for Mobile -->
    <div class="sidebar d-md-none bg-light" id="mobileSidebar">
      <h4 class="fw-bold text-primary mt-3 ms-3">📌 Admin Panel</h4>
      <hr>
      <a href="#" class="d-block mb-2 ms-3">➤ Doctors</a>
      <a href="add_pharmacy.php" class="d-block mb-2 ms-3 text-success">➤ Add Pharmacy</a>
      <a href="view_appointments.php" class="d-block mb-2 ms-3">➤ Appointments</a>
    </div>

    <!-- Main Form Content -->
    <div class="col-12 col-md-9 form-container p-4 mt-3">
      <h3 class="mb-4">➕ Add Doctor</h3>
      <form method="POST">
        <div class="row">
          <div class="mb-3 col-md-6">
            <label for="name" class="form-label">👤 Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter doctor's name" required>
          </div>
          <div class="mb-3 col-md-6">
            <label for="specialty" class="form-label">🩺 Specialty:</label>
            <input type="text" class="form-control" id="specialty" name="specialty" placeholder="e.g., Cardiologist" required>
          </div>
        </div>
        <div class="row">
          <div class="mb-3 col-md-6">
            <label for="location" class="form-label">📍 Location:</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Enter city or location" required>
          </div>
          <div class="mb-3 col-md-6">
            <label for="contact" class="form-label">📞 Contact:</label>
            <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter contact number" required>
          </div>
        </div>
        <div class="row">
          <div class="mb-3 col-md-6">
            <label for="email" class="form-label">📧 Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
          </div>
          <div class="mb-3 col-md-6">
            <label for="image_url" class="form-label">🖼️ Image URL:</label>
            <input type="text" class="form-control" id="image_url" name="image_url" placeholder="https://example.com/image.jpg">
          </div>
        </div>
        <button type="submit" class="btn btn-success mt-2">➕ Add Doctor</button>
      </form>
    </div>
  </div>
</div>

<!-- ✅ Required Bootstrap JS for navbar toggler to work -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('mobileSidebar');
    sidebar.classList.toggle('show');
  }
</script>

</body>
</html>
