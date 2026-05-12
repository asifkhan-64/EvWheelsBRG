<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $date = date_default_timezone_set("Asia/Karachi");
    $currentDate = date('Y-m-d h:i:s A');
    $date = date('Y-m-d');

    $duesQuery = mysqli_query($connect, "SELECT `stock_purchase`.*, batteries.* FROM `stock_purchase`
        INNER JOIN batteries ON batteries.b_id = stock_purchase.battery_id
        WHERE stock_purchase.bike_status = '1'");

    $get = mysqli_query($connect, "SELECT * FROM `shop_info`");
    $fet = mysqli_fetch_assoc($get);

// include '../_partials/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?php echo $fet['shop_title']; ?></title>
    <meta content="<?php echo $fet['shop_title']; ?>" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- <link rel="shortcut icon" href="../assets/LogoFinal.png"> -->
    <link rel="shortcut icon" href="../assets/ev-logo.png">
    <!--Morris Chart CSS -->

    <!-- DataTables -->
    <!-- Responsive datatable examples -->

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <script src='../assets/kit.js' crossorigin='anonymous'></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<style>

    body, td {
        color: black;
    }
    
    table {
        font-size: 14px !important;
    }

    table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
    
    .custom {
        font-size: 14px;
        color: black;
    }
</style>
<!-- Top Bar End -->

<br>
<div class="page-content-wrapper ">
    <div class="container-fluid">
        
        <!-- end row -->
        <div class="row custom">
            <div class="col-12">
                <!-- <div class="card m-b-30" > -->
                    <!-- <div class="card-body"> -->
                        <div class="row" id="printElement">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <div class="page-title-box d-flex align-items-center justify-content-between">
                                            <img src="../assets/ev-logo.png" alt="Logo" height="100" width="120">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="invoice-title">
                                            <h3 class="m-t-0 text-right">
                                                <h3 align="right" style="font-size: 150%; line-height: 1px; font-family: Lucida Handwriting "><u><?php echo $fet['shop_title'] ?></u></h3>
                                                <br > <!-- <h3 align="center" style="font-size: 100% ;  line-height: 15px; font-family: Lucida Handwriting "><u><?php echo $fet['shop_name'] ?></u></h3> -->
                                                <p class="text-right font-16" style="font-size: 100%;  line-height: 5px;"><?php echo $fet['shop_address'] ?></p>
                                                <p class="text-right font-16" style="font-size: 100%;  line-height: 5px;">Printed on: <?php echo date("Y-m-d h:i A") ?></p>
                                                <p class="text-right font-16" style="font-size: 100%;  line-height: 5px;"><b>(Stock Report) </b></p>
                                                <br>
                                            </h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <!-- <h6>Current Patients</h6> -->
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th> Model</th>
                                                        <th> Color</th>
                                                        <th> Battery</th>
                                                        <th> Avg</th>
                                                        <th> Watt</th>
                                                        <th> Purchase Date</th>
                                                        <th> Purchase Price</th>
                                                        <th> Selling Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $itrCurrent = 1;



                                                    $totalPurchase = 0;
                                                    $totalSell = 0;
                                                    while ($row = mysqli_fetch_assoc($duesQuery)) {
                                                        $totalPurchase += $row['bike_purchase_price'];
                                                        $totalSell += $row['bike_sell_price'];
                                                        echo '
                                                        <tr>
                                                            <td>'.$itrCurrent++.'.</td>
                                                            <td>'.$row['bike_model'].'</td>
                                                            <td>'.$row['bike_color'].'</td>
                                                            <td>'.$row['battery_name'].'</td>
                                                            <td>'.$row['bike_average'].'</td>
                                                            <td>'.$row['bike_watt'].'</td>
                                                            <td>'.$row['bike_purchase_date'].'</td>
                                                            <td>'.number_format($row['bike_purchase_price']).'</td>
                                                            <td>'.number_format($row['bike_sell_price']).'</td>
                                                        </tr>
                                                        ';
                                                    }?>

                                                    
                                                    <tr>
                                                        <td colspan="8" class="text-right"><strong>Total Purchase Amount:</strong></td>
                                                        <td><strong><?php echo number_format($totalPurchase); ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" class="text-right"><strong>Total Sell Amount:</strong></td>
                                                        <td><strong><?php echo number_format($totalSell); ?></strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                

                               

                               

                            </div>
                        </div>
                    <!-- </div> -->
                <!-- </div> -->
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
</div><!-- container fluid -->
</div> <!-- Page content Wrapper -->
</div> <!-- content -->
<?php // include '../_partials/footer.php'?>
</div>
<!-- End Right content here -->
</div>
<!-- END wrapper -->
<!-- jQuery  -->
<?php include '../_partials/jquery.php'?>
<!-- App js -->
<script type="text/javascript" src="../assets/print.js"></script>


<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
  window.addEventListener("load", window.print());
</script>
</body>

</html>