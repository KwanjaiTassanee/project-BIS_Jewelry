<?php
session_start();

// User Authentication
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Web Master Says : : Login First :-( !!!')</script>";
    echo "<meta http-equiv='refresh' content='2;url=../index-1.php'>";
    exit();
} elseif (!isset($_SESSION['status'])) {
    echo "<script>alert('INTRUDER!!!: :')</script>";
    echo "<meta http-equiv='refresh' content='2;url=../index-1.php'>";
    exit();
} else {
    $admin = $_SESSION['username'];
}

include('includes/connect-db.php');

// Dashboard Data Queries
$total_products = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS total FROM jewellery"))['total'] ?? 0;
$total_cart_items = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(qty) AS total FROM cart WHERE checkout = 0"))['total'] ?? 0;
$total_qty_sold = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(qty) AS total FROM cart WHERE checkout = 1"))['total'] ?? 0;
$total_checked_out_orders = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(DISTINCT trans) AS total FROM cart WHERE checkout = 1"))['total'] ?? 0;

// If you have revenue logic, add it here (currently $0)
$total_revenue = 0.00;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title> Admin Destiny Company</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <!-- Sidebar toggle -->
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="adminhome.php" class="nav-link">Dashboard</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link text-center">
      <span class="brand-text font-weight-light">Destiny Company</span>
    </a>
    <div class="sidebar">
      <?php include("adminmenu.php"); ?>
    </div>
  </aside>

  <!-- Main Content -->
  <div class="content-wrapper">
    <section class="content pt-4">
      <div class="container-fluid">
        <h3 class="text-center mb-4">Welcome, <strong><?= htmlspecialchars($admin) ?></strong></h3>

        <div class="row">
          <!-- Total Products -->
          <div class="col-12 col-sm-6 col-lg-4 mb-3">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= number_format($total_products) ?> รายการ</h3>
                <p>Total Products</p>
              </div>
              <div class="icon"><i class="fas fa-boxes"></i></div>
            </div>
          </div>

          <!-- Total Revenue -->
          <div class="col-12 col-sm-6 col-lg-4 mb-3">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>฿<?= number_format($total_revenue, 2) ?></h3>
                <p>Total Revenue</p>
              </div>
              <div class="icon"><i class="fas fa-dollar-sign"></i></div>
            </div>
          </div>

          <!-- Orders Placed -->
          <div class="col-12 col-sm-6 col-lg-4 mb-3">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= number_format($total_checked_out_orders) ?></h3>
                <p>Orders Placed</p>
              </div>
              <div class="icon"><i class="fas fa-receipt"></i></div>
            </div>
          </div>

          <!-- Cart Items -->
          <div class="col-12 col-sm-6 col-lg-6 mb-3">
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?= number_format($total_cart_items) ?></h3>
                <p>Items in Cart (Pending)</p>
              </div>
              <div class="icon"><i class="fas fa-shopping-cart"></i></div>
            </div>
          </div>

          <!-- Quantity Sold -->
          <div class="col-12 col-sm-6 col-lg-6 mb-3">
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3><?= number_format($total_qty_sold) ?></h3>
                <p>Total Quantity Sold</p>
              </div>
              <div class="icon"><i class="fas fa-box-open"></i></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>&copy; <?= date("Y") ?> Destiny Company</strong> | All rights reserved.
  </footer>

</div>

<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>

<?php
mysqli_close($connection);
?>
