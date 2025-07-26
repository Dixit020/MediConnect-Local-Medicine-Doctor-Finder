<?php
session_start();
include 'db.php'; // make sure this file connects to your DB

// Get doctor ID from URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM doctors WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $doctor = $stmt->get_result()->fetch_assoc();

    if (!$doctor) {
        echo "Doctor not found.";
        exit;
    }
} else {
    echo "No doctor ID provided.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($doctor['name']) ?> - Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .card img {
      width: 120px;
      height: 120px;
      object-fit: cover;
    }
    @media (max-width: 576px) {
      .card { padding: 1rem; }
      .btn { width: 100%; }
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
        <li class="nav-item"><a class="nav-link" href="medicine.php">Medicine</a></li>
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

<!-- Profile Section -->
<div class="container mt-5">
  <div class="card text-center mx-auto" style="max-width: 500px;">
    <div class="card-body">
    <img 
  src="<?= !empty($doctor['image']) ? htmlspecialchars($doctor['image']) : 'https://via.placeholder.com/120' ?>" 
  class="rounded-circle mb-3" 
  alt="Doctor Image"
/>

      <h4 class="card-title"><?= htmlspecialchars($doctor['name']) ?></h4>
      <p><strong>Specialization:</strong> <?= htmlspecialchars($doctor['specialization']) ?></p>
      <p><strong>Location:</strong> <?= htmlspecialchars($doctor['city']) ?></p>
      <p><strong>Contact:</strong> <?= htmlspecialchars($doctor['contact']) ?></p>
     <a href="appointment.php?doctor=<?= urlencode($doctor['name']) ?>" class="btn btn-success mb-3 w-100">📅 Book Appointment</a>

      <div class="ratio ratio-16x9">
        <iframe 
          src="https://maps.google.com/maps?q=<?= urlencode($doctor['city']) ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" 
          allowfullscreen 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
