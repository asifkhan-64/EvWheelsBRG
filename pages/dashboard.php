<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$date = date_default_timezone_set("Asia/Karachi");
$currentDate = date('Y-m-d h:i:s A');
$date = date('Y-m-d');

$getStockInfo = mysqli_query($connect, "SELECT COUNT(*) AS totalStock FROM `stock_purchase` WHERE bike_status = '1'");
$fetStockInfo = mysqli_fetch_assoc($getStockInfo);
$stock = $fetStockInfo['totalStock'];

$getExpenseDaily = mysqli_query($connect, "SELECT SUM(expense_amount) AS totalExpense FROM `expense` WHERE expense_date = '$date'");
$fetExpenseDaily = mysqli_fetch_assoc($getExpenseDaily);
$dailyExpense = $fetExpenseDaily['totalExpense'];

$marketDuesQuery = mysqli_query($connect, "SELECT SUM(total_dues) AS marketDues FROM `customer_add`");
$fetMarketDues = mysqli_fetch_assoc($marketDuesQuery);
$cusdues = $fetMarketDues['marketDues'];

$claimsQuery = mysqli_query($connect, "SELECT COUNT(*) AS totalClaims FROM `claims` WHERE claim_status = '1'");
$fetClaims = mysqli_fetch_assoc($claimsQuery);
$totalClaims = $fetClaims['totalClaims'];

include('../_partials/header.php');

?>

<link rel="stylesheet" type="text/css" href="./timeline.css">

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title"><i class="dripicons-meter"></i>&nbsp;&nbsp;Dashboard</h5>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="main-timeline2" id="addUserForm">
                    <div class="timeline animate__animated animate__bounce" id="timeline">
                        <span class="icon fa fa-globe"></span>
                        <a class="timeline-content" style="box-shadow: 10px 10px 10px 10px #ccc">
                            <h3 class="title" align="center"><?php echo $fet['shop_title'] ?></h3>
                            <h3 class="title" align="center"><?php echo $fet['shop_name'] ?></h3>
                            <hr>
                            <p class="description" align="center">
                                <?php echo $fet['shop_address'] ?>
                            </p>
                        </a>
                    </div>
                    <div class="timeline animate__animated animate__bounce">
                        <span class="icon fa fa-calendar"></span>
                        <a class="timeline-content" style="box-shadow: 10px 10px 10px 10px #ccc">
                            <h3 class="title" align="center">EV Bikes (In Stock)</h3>
                            <hr>
                            <p class="description" align="center">
                                 
                                <?php
                                if (empty($stock)) {
                                    echo "0";
                                } else {
                                    echo $stock;
                                }
                                ?>
                            </p>
                        </a>
                    </div>

                    <div class="timeline animate__animated animate__bounce">
                        <span class="icon fa fa-window-close"></span>
                        <a class="timeline-content" style="box-shadow: 10px 10px 10px 10px #ccc">
                            <h3 class="title" align="center">Market Dues</h3>
                            <hr>
                            <p class="description" align="center">
                                 <?php
                                    if (empty($cusdues)) {
                                        echo "0";
                                    } else {
                                        echo "Pkr. ".number_format($cusdues);
                                    }
                                ?>
                            </p>
                        </a>
                    </div>

                    <div class="timeline animate__animated animate__bounce">
                        <span class="icon fa fa-calendar"></span>
                        <a class="timeline-content" style="box-shadow: 10px 10px 10px 10px #ccc">
                            <h3 class="title" align="center">Expense (<?php echo $date; ?>)</h3>
                            <hr>
                            <p class="description" align="center">
                                 
                                <?php
                                if (empty($dailyExpense)) {
                                    echo "0";
                                } else {
                                    echo number_format($dailyExpense);
                                }
                                ?>
                            </p>
                        </a>
                    </div>

                    <div class="timeline animate__animated animate__bounce">
                        <span class="icon fa fa-window-close"></span>
                        <a class="timeline-content" style="box-shadow: 10px 10px 10px 10px #ccc">
                            <h3 class="title" align="center">Claims (Pending)</h3>
                            <hr>
                            <p class="description" align="center">
                                 <?php
                                    if (empty($totalClaims)) {
                                        echo "0";
                                    } else {
                                        echo $totalClaims;
                                    }
                                ?>
                            </p>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <br>
    </div>
</div>
</div>
<?php include '../_partials/footer.php'; ?>

</div>
<!-- End Right content here -->

</div>
<!-- END wrapper -->


<!-- jQuery  -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/modernizr.min.js"></script>
<script src="../assets/js/detect.js"></script>
<script src="../assets/js/fastclick.js"></script>
<script src="../assets/js/jquery.slimscroll.js"></script>
<script src="../assets/js/jquery.blockUI.js"></script>
<script src="../assets/js/waves.js"></script>
<script src="../assets/js/jquery.nicescroll.js"></script>
<script src="../assets/js/jquery.scrollTo.min.js"></script>

<!-- skycons -->
<script src="../assets/plugins/skycons/skycons.min.js"></script>

<!-- skycons -->
<script src="../assets/plugins/peity/jquery.peity.min.js"></script>

<!--Morris Chart-->
<script src="../assets/plugins/morris/morris.min.js"></script>
<script src="../assets/plugins/raphael/raphael-min.js"></script>

<!-- dashboard -->
<script src="../assets/pages/dashboard.js"></script>

<!-- App js -->
<script src="../assets/js/app.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>


// All animations will take twice the time to accomplish
document.documentElement.style.setProperty('--animate-duration', '2s');

// All animations will take half the time to accomplish
document.documentElement.style.setProperty('--animate-duration', '.5s');
</script>

</body>

</html>