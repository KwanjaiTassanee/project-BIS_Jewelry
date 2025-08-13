<?php
session_start();

// Authentication check
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

// Fetch categories
$sql = "SELECT * FROM main_menu ORDER BY mmenu_id ASC";
$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>View Category Records</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <!-- AdminLTE + Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" />
</head>
<body class="hold-transition sidebar-mini">
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

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <section class="content pt-4">
      <div class="container-fluid">

        <h3 class="text-center mb-4">View Category Records</h3>
        <p class="text-center">
          Hi, <strong><?= htmlspecialchars($admin) ?></strong>. Good to see you working! 
          <!-- || <a href="logout.php">Logout</a> -->
        </p>

        <div class="mb-3 text-center">
          <a href="viewcategories-paginated.php?page=1" class="btn btn-secondary btn-sm me-2">View Paginated</a>
          <a href="newcategory.php" class="btn btn-success btn-sm">Enter New Category</a>
        </div>

        <div class="card">
          <div class="card-body table-responsive">
            <table class="table table-bordered table-striped text-center align-middle">
              <thead class="table-dark">
                <tr>
                  <th>Menu ID</th>
                  <th>Menu Name</th>
                  <th>Menu Link</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                  <td><?= $row['mmenu_id'] ?></td>
                  <td><?= htmlspecialchars($row['mmenu_name']) ?></td>
                  <td><?= htmlspecialchars($row['mmenu_link']) ?></td>
                  <td>
                    <a href="editcategory.php?id=<?= $row['mmenu_id'] ?>" class="btn btn-primary btn-sm">
                      <i class="fas fa-edit"></i> Edit
                    </a>
                  </td>
                  <td>
                    <a href="deletecategory.php?paginated=no&id=<?= $row['mmenu_id'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure you want to delete this category?');">
                      <i class="fas fa-trash-alt"></i> Delete
                    </a>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </section>
  </div>

  <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>&copy; <?= date("Y") ?> Web Master Area.</strong> All rights reserved.
  </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>

<?php mysqli_close($connection); ?>
