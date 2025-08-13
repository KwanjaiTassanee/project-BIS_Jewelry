<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>VIEW SUB CATEGORY RECORDS - PAGINATED</title>
    <link rel="stylesheet" type="text/css" href="adminstyle.css">
</head>
<body>

<?php
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Web Master Says : : Login First :-( !!!')</script>";
    echo "<meta http-equiv='refresh' content='2;url=../index-1.php'>";
    exit();
} else if (!isset($_SESSION['status'])) {
    echo "<script>alert('INTRUDER!!!: :')</script>";
    echo "<meta http-equiv='refresh' content='2;url=../index-1.php'>";
    exit();
} else {
    $admin = $_SESSION['username'];
}
?>

<p align="center"><b>VIEW SUB CATEGORY RECORDS - PAGINATED</b></p>
<?php echo 'Hi, <strong>' . $admin . '</strong> Good To See You Working! || <a href="logout.php"> Logout </a>'; ?>
<br />
<div align="center">
    <?php include("adminmenu.php"); ?>
</div>

<?php
// connect to the database
include('includes/connect-db.php'); // ensure this file uses mysqli too

// number of results to show per page
$per_page = 5;

// figure out the total pages in the database
$query_all = "SELECT * FROM main_menu, sub_menu WHERE main_menu.mmenu_id = sub_menu.mmenu_id ORDER BY sub_menu.id ASC";
$result_all = mysqli_query($connection, $query_all);

$total_results = mysqli_num_rows($result_all);
$total_pages = ceil($total_results / $per_page);

// determine which page number visitor is currently on
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = (int) $_GET['page'];
    if ($current_page < 1 || $current_page > $total_pages) {
        $current_page = 1;
    }
} else {
    $current_page = 1;
}

$offset = ($current_page - 1) * $per_page;

// get the selected results from the database 
$query_paginated = "SELECT * FROM main_menu, sub_menu 
                    WHERE main_menu.mmenu_id = sub_menu.mmenu_id 
                    ORDER BY sub_menu.id ASC 
                    LIMIT $offset, $per_page";
$result = mysqli_query($connection, $query_paginated);

// display pagination
echo "<p><a href='viewsubcat.php'>View All</a> | <b>View Page:</b> ";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='viewsubcat-paginated.php?page=$i'>$i</a> ";
}
echo " | <a href='newsubcat.php'>Enter New Sub Category</a></p>";

// display data in table
echo "<table align='center' border='1' cellpadding='10'>";
echo "<tr> 
        <th>MENU ID</th> 
        <th>MAIN MENU ID</th>  
        <th>MAIN MENU NAME</th> 
        <th>SUB MENU NAME</th> 
        <th>SUB MENU LINK</th> 
        <th></th> 
        <th></th>
      </tr>";

// loop through results of database query, displaying them in the table 
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['mmenu_id'] . '</td>';
    echo '<td>' . $row['mmenu_name'] . '</td>';
    echo '<td>' . $row['smenu_name'] . '</td>';
    echo '<td>' . $row['smenu_link'] . '</td>';
    echo '<td><a href="editsubcat.php?id=' . $row['id'] . '">Edit</a></td>';
    echo '<td><a href="deletesubcat.php?paginated=yes&id=' . $row['id'] . '">Delete</a></td>';
    echo "</tr>";
}
echo "</table>";
?>

</body>
</html>
