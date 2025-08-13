<?php
$start = microtime(true);
session_start(); // start a session

include("includes/config.php"); // ✅ เพิ่มการเชื่อมต่อฐานข้อมูล

if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
} else {
    $userid = "";
}
echo "User ID: " . $userid;
?>

<?php
$_SESSION['code'] = rand();
$code = $_SESSION['code'];
echo "<br />Code: " . $code;
?>

<?php
if (isset($_SESSION['username'])) {
    $User = $_SESSION['username'];
} else {
    $User = "";
}
?>

<!-- Head1 Part Start-->
<?php include("head1.html"); ?>
<!-- Head1 Part End-->

<!-- Top Part Start-->
<?php 
if ($User != "") {
    include("top_links2.php");
} else {
    include("top_links.php");
}
?>
<!-- Top Part End-->

<!-- Main Div Tag Start-->
<div id="wrapper">

    <!-- Header Part Start-->
    <?php 
    if ($User != "") {
        include("header2.php");
    } else {
        include("header.php");
    }
    ?>
    <!-- Header Part End-->
    
    <!-- Middle Part Start--> 
    <!-- Section Start--> 
    <?php include("section.html"); ?>
    <!--Section End-->
    <!--Middle Part End-->

    <!--Random Featured Product Start-->
    <div class="box mb0" id="randomfeatured">
        <div class="box-heading-1"><span>Random Featured</span></div>
        <div class="box-content-1">
            <div class="box-product-1">
                <?php include("randomfeatured.php"); ?>
            </div>
        </div>
    </div>
    <!--Random Featured Product End-->

    <!--Special Promo Banner Start-->
    <div class="box-promo" id="box-promo">
        <div class="box-heading-1"><span>PROMO ON FEATURED ITEMS</span></div>
        <div id="banner0" class="banner">
            <div style="display:block;">
                <img src="image/addBanner-940x145.jpg" alt="Special Offers" title="Special Offers" />
            </div>
        </div>
    </div>
    <!--Special Promo Banner End-->    	

    <!--Coming Soon Product Start-->
    <div class="box-heading-1" id="soon">
        <div class="box-heading-1"><span>Coming Soon</span></div>
        <div id="carousel0">
            <ul class="jcarousel-skin-opencart">
                <?php include("comingsoon.php"); ?>
            </ul>
        </div>
    </div>
    <!--Coming Soon Product End-->

    <!--Footer Part Start-->
    <?php include("footer.php"); ?>
    <!--Footer Part End-->
</div>
<!-- Main Div Tag End-->

<!--Flexslider Javascript Part Start-->
<?php include("flexslider.php"); ?>
<!--Flexslider Javascript Part End-->

<?php
$end = microtime(true);
$elapsed = $end - $start;
echo "Procedure 1 = {$elapsed} seconds";
?>
</body>
</html>
