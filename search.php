<?php
$conn = new mysqli("localhost", "root", "", "mediconnect");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$location = isset($_GET['location']) ? trim($_GET['location']) : '';
$specialty = isset($_GET['specialty']) ? trim($_GET['specialty']) : '';

$location_safe = $conn->real_escape_string($location);
// $specialty_safe = $conn->real_escape_string($specialty);

// Final DISTINCT query with selected columns only
$sql = "SELECT DISTINCT name, specialization, city, contact, email FROM doctors WHERE 1";

if (!empty($location_safe)) {
  $sql .= " AND city LIKE '%$location_safe%'";
}

if (!empty($specialty_safe)) {
  $sql .= " AND specialization LIKE '%$specialty_safe%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Results – MediConnect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Search Results</h2>

  <?php if ($result && $result->num_rows > 0): ?>
    <div class="row">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col-md-4">
          <div class="card mb-4 shadow">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
              <p class="card-text">
                <strong><?php echo htmlspecialchars($row['specialization']); ?></strong><br>
                📍 <?php echo htmlspecialchars($row['city']); ?><br>
                📞 <?php echo htmlspecialchars($row['contact']); ?><br>
                📧 <?php echo htmlspecialchars($row['email']); ?>
                <a href="doctors-profile.php?email=<?php echo urlencode($row['email']); ?>" class="btn btn-secondary w-45">📄 View</a>

              </p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-warning">No doctors found for your search.</div>
  <?php endif; ?>

  <a href="index.php" class="btn btn-outline-secondary mt-3">← Back to Home</a>
</div>
</body>
</html>

<?php $conn->close(); ?>
