<?php
session_start();

// Auth check
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
$src = "../Photos/";

// Fetch distinct categories for dropdown
$catResult = mysqli_query($connection, "SELECT DISTINCT category FROM jewellery ORDER BY category ASC");
$categories = [];
while ($row = mysqli_fetch_assoc($catResult)) {
    $categories[] = $row['category'];
}

// Get selected category filter
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

// Build SQL WHERE clause based on category filter
$whereSQL = '';
if ($category !== '') {
    $safeCategory = mysqli_real_escape_string($connection, $category);
    $whereSQL = "WHERE category = '$safeCategory'";
}

// Query products filtered by category
$sql = "SELECT * FROM jewellery $whereSQL ORDER BY id ASC";
$result = mysqli_query($connection, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>View Products Records</title>
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
        <h3 class="text-center mb-4">View Products Records</h3>
        <p class="text-center">Hi, <strong><?= htmlspecialchars($admin) ?></strong>. Good to see you working!</p>

        <!-- Category Filter Form -->
        <form method="GET" class="mb-3">
          <div class="row g-2 justify-content-center">
            <div class="col-md-3">
              <select name="category" class="form-select">
                <option value="">-- Filter by Category --</option>
                <?php foreach ($categories as $cat): ?>
                  <option value="<?= htmlspecialchars($cat) ?>" <?= ($cat === $category) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Enter</button>
              <a href="viewprod.php" class="btn btn-secondary"><i class="fas fa-times"></i> Reset</a>
            </div>
          </div>
        </form>

        <!-- Action Buttons -->
        <div class="mb-3 text-center">
          <a href="viewprod-paginated.php?page=1" class="btn btn-sm btn-secondary">View Paginated</a>
          <a href="newprod.php" class="btn btn-sm btn-success">Add New Product</a>
        </div>

        <!-- Products Table -->
        <div class="card">
          <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped text-center align-middle mb-0">
              <thead class="table-dark">
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Image Page</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Description</th>
                  <th>Type</th>
                  <th>Views</th>
                  <th>Image</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                  <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                      <td><?= $row['id'] ?></td>
                      <td><?= htmlspecialchars($row['prodname']) ?></td>
                      <td><?= htmlspecialchars($row['path']) ?></td>
                      <td><?= htmlspecialchars($row['category']) ?></td>
                      <td><?= htmlspecialchars($row['price']) ?></td>
                      <td><?= htmlspecialchars($row['descr']) ?></td>
                      <td><?= htmlspecialchars($row['type']) ?></td>
                      <td><?= htmlspecialchars($row['noviews']) ?></td>
                      <td>
                        <img src="<?= $src . htmlspecialchars($row['path']) ?>" width="80" height="80" class="img-thumbnail" alt="Product Image" />
                      </td>
                      <td>
                        <a href="editprod.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary mb-1">
                          <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="deleteprod.php?paginated=no&id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">
                          <i class="fas fa-trash-alt"></i> Delete
                        </a>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr><td colspan="10" class="text-center">No products found.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </section>
  </div>

  <footer class="main-footer text-center">
    <strong>&copy; <?= date("Y") ?> Web Master Area.</strong> All rights reserved.
  </footer>

</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>

<?php
// Close DB connection
mysqli_close($connection);
?>
