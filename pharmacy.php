<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pharmacies Nearby - MediConnect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

<!-- Main Content -->
<div class="container mt-5 mb-5">
  <h2 class="text-center mb-4">🏥 Pharmacies Nearby</h2>

  <!-- Filter by Location -->
  <form method="GET" class="row mb-4">
    <div class="col-12 col-md-6 offset-md-3 d-flex">
      <input type="text" name="location" class="form-control me-2" placeholder="🔍 Enter City / Location" value="<?= isset($_GET['location']) ? htmlspecialchars($_GET['location']) : '' ?>">
      <button type="submit" class="btn btn-primary">Search</button>
    </div>
  </form>

<?php
$conn = new mysqli("localhost", "root", "", "mediconnect");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Search logic
$locationFilter = "";
$limitClause = "LIMIT 6";
if (isset($_GET['location']) && !empty(trim($_GET['location']))) {
  $location = $conn->real_escape_string($_GET['location']);
  $locationFilter = "WHERE location LIKE '%$location%'";
}

// Show all if view=all in URL
if (isset($_GET['view']) && $_GET['view'] === 'all') {
  $limitClause = "";
}

// Final query
$sql = "SELECT * FROM pharmacies $locationFilter ORDER BY id DESC $limitClause";
$result = $conn->query($sql);
?>

  <div class="row">
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="col-md-4 col-sm-6 mb-4">
          <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
              <h5 class="card-title text-primary fw-bold">🏥 <?= htmlspecialchars($row['name']) ?></h5>
              <p class="mb-1"><strong>📍 Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
              <p><strong>📞 Contact:</strong> <?= htmlspecialchars($row['contact']) ?></p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
  <div class="col-12">
    <div class="alert alert-warning text-center">No pharmacies found for your search.</div>
  </div>
<?php endif; ?>

<!-- See All Button -->
<?php
// Show "See All" only if more results might exist
if (!isset($_GET['view']) || $_GET['view'] !== 'all') {
  $seeAllURL = "pharmacy.php?view=all";
  if (!empty($_GET['location'])) {
    $seeAllURL .= "&location=" . urlencode($_GET['location']);
  }
  echo '<div class="text-center mt-4"><a href="' . $seeAllURL . '" class="btn btn-outline-primary">See All Pharmacies</a></div>';
}
?>

  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
