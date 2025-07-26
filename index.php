<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MediConnect – Homepage</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

<div class="container my-5">
  <div class="p-4 bg-light rounded shadow-sm text-center">
    <h4 class="fw-bold text-primary mb-2">
      Search for a Doctor
    </h4>
    <p class="text-secondary mb-0">
      Visit the <a href="doctors.php" class="text-decoration-none fw-semibold text-success">Doctors page</a> to find the nearest doctor around you.
    </p>
  </div>
</div>


<!-- Featured Doctors -->
<section class="py-5" style="background-color: antiquewhite;">
  <div class="container">
    <h2 class="mb-4 text-center">Top Doctors</h2>
    <div class="row g-4">
      <div class="col-12 col-md-4">
        <div class="card h-100">
          <img src="https://images.jdmagicbox.com/v2/comp/mehsana/i5/9999p2762.2762.241003110335.w3i5/catalogue/aadhyaa-ortho-care-dr-angel-patel-radhanpur-cir-mehsana-orthopaedic-doctors-x2pmcbjjm1-250.jpg" class="card-img-top" alt="Doctor Image">
          <div class="card-body">
            <h5 class="card-title">Dr. Vinod Patel </h5>
            <p class="card-text">Orthopedic surgeon <br>experience Doctor </p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card h-100">
          <img src="https://www.iite.ac.in/backend/thumb/ckeditor/0/0/1592223617vcsir.jpg" class="card-img-top" alt="Doctor Image">
          <div class="card-body">
            <h5 class="card-title">Dr.Harashad Patel </h5>
            <p class="card-text"> MD Pathology <br>experience Doctor</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card h-100">
          <img src="https://cdn.hexahealth.com/Image/webp/480x480/1749285092925-956375192.webp" class="card-img-top" alt="Doctor Image">
          <div class="card-body">
            <h5 class="card-title">Dr.Amit Sanghavi</h5>
            <p class="card-text">Eye surgeon<br> 5+ years experience</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Featured Pharmacies -->
<section class="py-5 text-white" style="background-color: rgb(102, 163, 233);">
  <div class="container">
    <h2 class="mb-4 text-center">Top Pharmacies</h2>
    <div class="row g-4">
      <div class="col-12 col-md-4">
        <div class="card h-100">
         
          <div class="card-body">
            <h5 class="card-title">Arihant Medical</h5>
            <p class="card-text">Open 24/7 | Location: Gunj Bazar-vadnagar</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card h-100">
          
          <div class="card-body">
            <h5 class="card-title">Cilia Pharmaceuticals</h5>
            <p class="card-text">Open 24/7 | Location: F‑18 Devarshi Enclave, Visnagar Road-mehsana</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card h-100">
          
          <div class="card-body">
            <h5 class="card-title">Mamta Medical Store</h5>
            <p class="card-text">Open 24/7 | Location: New ST Stand Road-kadi</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white text-center p-3">
  <div class="container">
    <p>© 2025 MediConnect | 
      <a href="#" class="text-white text-decoration-underline">Contact</a> | 
      <a href="#" class="text-white text-decoration-underline">About</a> | 
      <a href="#" class="text-white text-decoration-underline">Terms & Conditions</a>
    </p>
  </div>
</footer>

</body>
</html>
