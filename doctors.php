<?php
session_start();
$conn = new mysqli("localhost", "root", "", "mediconnect");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$search_location = isset($_GET['location']) ? trim($_GET['location']) : '';
$search_specialty = isset($_GET['specialty']) ? trim($_GET['specialty']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Doctors - MediConnect</title>
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

<!-- Search Bar -->
<div class="container mt-5">
  <form method="GET" class="row g-3 mb-4">
    <div class="col-md-5">
      <input type="text" name="location" class="form-control" placeholder="📍 Search by Location" value="<?= htmlspecialchars($search_location) ?>">
    </div>
    <div class="col-md-5">
      <input type="text" name="specialty" class="form-control" placeholder="🩺 Search by Specialty" value="<?= htmlspecialchars($search_specialty) ?>">
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary w-100">Search</button>
    </div>
  </form>

  <h2 class="text-center mb-4">👨‍⚕️ Doctors Near You</h2>

  <div class="row">
    <?php
    $sql = "SELECT DISTINCT id, name, specialization, city, contact, image  FROM doctors WHERE 1=1";
    if (!empty($search_location)) {
      $sql .= " AND city LIKE '%" . $conn->real_escape_string($search_location) . "%'";
    }
    if (!empty($search_specialty)) {
      $sql .= " AND specialization LIKE '%" . $conn->real_escape_string($search_specialty) . "%'";
    }
   $view_all = isset($_GET['view']) && $_GET['view'] === 'all';
$sql .= " ORDER BY name ASC";

if (!$view_all) {
  $sql .= " LIMIT 6";
}


    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0):
      while ($row = $result->fetch_assoc()):
    ?>
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm">
          <img src="<?= htmlspecialchars($row['image'] ?: '.jpg') ?>" class="card-img-top" alt="Doctor Image" style="height: 220px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
            <p class="card-text mb-1">🩺 <strong>Specialty:</strong> <?= htmlspecialchars($row['specialization']) ?></p>
            <p class="card-text mb-1">📍 <strong>Location:</strong> <?= htmlspecialchars($row['city']) ?></p>
            <p class="card-text mb-3">📞 <strong>Contact:</strong> <?= htmlspecialchars($row['contact']) ?></p>
            <div class="d-flex justify-content-between">
              <a href="tel:<?= htmlspecialchars($row['contact']) ?>" class="btn btn-primary btn-sm">📞 Call</a>
              <a href="doctors-profile.php?id=<?= urlencode($row['id']) ?>" class="btn btn-secondary btn-sm">📄 View</a>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; else: ?>
      <div class="col-12 alert alert-warning text-center">No doctors found.</div>
    <?php endif; ?>
  </div>
</div>
<?php if (!isset($_GET['view']) || $_GET['view'] !== 'all'): ?>
  <div class="col-12 text-center mt-3">
    <?php
  $seeAllURL = "doctors.php?view=all";
  if (!empty($search_location)) {
    $seeAllURL .= "&location=" . urlencode($search_location);
  }
  if (!empty($search_specialty)) {
    $seeAllURL .= "&specialty=" . urlencode($search_specialty);
  }
?>
<a href="<?= $seeAllURL ?>" class="btn btn-outline-primary">See All Doctors</a>

  </div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
