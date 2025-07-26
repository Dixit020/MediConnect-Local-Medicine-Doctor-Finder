<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Pharmacy - MediConnect</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .sidebar {
      background-color: #f8f9fa;
      padding: 15px;
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
  </style>
</head>
<body>
<header class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container">
    <a class="navbar-brand text-primary fw-bold" href="#">MediConnect</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="doctors.php">Doctors</a></li>
        <li class="nav-item"><a class="nav-link active" href="pharmacy.php">Pharmacy</a></li>
        <li class="nav-item"><a class="nav-link" href="admin-dashboard.php">Admin</a></li>
      </ul>
      <div class="d-flex">
        <a href="login.php" class="btn btn-outline-primary me-2">Login</a>
        <a href="signup.php" class="btn btn-primary">Sign Up</a>
      </div>
    </div>
  </div>
</header>

<?php
$conn = new mysqli("localhost", "root", "", "mediconnect");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $location = $_POST['location'];
  $contact = $_POST['contact'];
  

  $sql = "INSERT INTO pharmacies (name, location, contact) VALUES ('$name', '$location', '$contact')";
  if ($conn->query($sql) === TRUE) {
    echo "<div class='alert alert-success m-3'>Pharmacy added successfully.</div>";
  } else {
    echo "<div class='alert alert-danger m-3'>Error: " . $conn->error . "</div>";
  }
}
?>

<div class="container-fluid">
  <div class="row">
    <!-- Toggle Button -->
    <div class="d-block d-md-none toggle-btn">
      <button class="btn btn-primary" onclick="toggleSidebar()">☰ Menu</button>
    </div>
<!-- Sidebar -->
<div class="col-md-3 sidebar" id="sidebar">
  <h4>📌 Admin Panel</h4>
  <hr>
  <a href="admin-dashboard.php" class="d-block mb-2">➤ Doctors</a>
  <a href="add_pharmacy.php" class="d-block mb-2 fw-bold text-primary">➤ Pharmacies</a>
  <a href="view_appointments.php" class="d-block mb-2">➤ Appointments</a>
</div>


    <!-- Main Content -->
    <div class="col-12 col-md-9 px-4 py-3">
      <h3 class="mb-4">➕ Add Pharmacy</h3>
      <form method="POST">
        <div class="mb-3">
          <label for="name" class="form-label">Pharmacy Name:</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Enter pharmacy name" required>
        </div>
        <div class="mb-3">
          <label for="location" class="form-label">Location:</label>
          <input type="text" class="form-control" id="location" name="location" placeholder="Enter location" required>
        </div>
        <div class="mb-3">
          <label for="contact" class="form-label">Contact:</label>
          <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter contact number" required>
        </div>
        
        <button type="submit" class="btn btn-success">Add Pharmacy</button>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('show');
  }
</script>

</body>
</html>
