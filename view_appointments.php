<?php
session_start();
$conn = new mysqli("localhost", "root", "", "mediconnect");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$appointments = [];
$searchDoctor = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $searchDoctor = $_POST['doctor_name'];
  $today = date("Y-m-d");
  $stmt = $conn->prepare("SELECT * FROM appointments WHERE doctor_name LIKE ? AND appointment_date = ?");
  $searchTerm = "%" . $searchDoctor . "%";
  $stmt->bind_param("ss", $searchTerm, $today);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Today's Appointments - Admin Panel</title>
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
    </div>
  </div>
</header>

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
      <a href="admin-dashboard.php" class="d-block mb-2">➤ Doctors</a>
      <a href="add_pharmacy.php" class="d-block mb-2 text-success">➤ Add Pharmacy</a>
      <a href="view_appointments.php" class="d-block mb-2 ms-3 fw-bold text-primary">➤ Appointments</a>
    </div>

    <!-- Mobile Sidebar -->
    <div class="sidebar d-md-none bg-light" id="mobileSidebar">
      <h4 class="fw-bold text-primary mt-3 ms-3">📌 Admin Panel</h4>
      <hr>
      <a href="admin-dashboard.php" class="d-block mb-2 ms-3">➤ Doctors</a>
      <a href="add_pharmacy.php" class="d-block mb-2 ms-3 text-success">➤ Add Pharmacy</a>
      <a href="view_appointments.php" class="d-block mb-2 ms-3 fw-bold text-primary">➤ Appointments</a>
    </div>

    <!-- Main Content -->
    <div class="col-12 col-md-9 p-4 mt-3">
      <h3 class="mb-4">📅 Today's Appointments</h3>
      <form method="POST" class="row mb-4">
        <div class="col-md-8 mb-2">
          <input type="text" name="doctor_name" class="form-control" placeholder="Search by doctor name..." value="<?= htmlspecialchars($searchDoctor) ?>" required>
        </div>
        <div class="col-md-4 mb-2">
          <button type="submit" class="btn btn-primary w-100">🔍 Search</button>
        </div>
      </form>

      <?php if (!empty($appointments)): ?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead class="table-dark">
              <tr>
                <th>Doctor Name</th>
                <th>Appointment Date</th>
                <th>Time</th>
                <th>User Email</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($appointments as $appt): ?>
                <tr>
                  <td><?= htmlspecialchars($appt['doctor_name']) ?></td>
                  <td><?= htmlspecialchars($appt['appointment_date']) ?></td>
                  <td><?= htmlspecialchars($appt['appointment_time']) ?></td>
                  <td><?= htmlspecialchars($appt['user_email']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php elseif ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
        <div class="alert alert-warning text-center">❌ No appointments found for today.</div>
      <?php endif; ?>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('mobileSidebar');
    sidebar.classList.toggle('show');
  }
</script>
</body>
</html>
