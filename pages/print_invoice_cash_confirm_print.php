<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}
$id = $_GET['id'];
$invoiceNo = $_GET['invoiceNo'];

$getInvoiceItems = mysqli_query($connect, "SELECT customer_qty_invoice.*, customer_qty_invoice.prod_qty AS qty, stock_purchase.*, batteries.battery_name, batteries.battery_warranty FROM `customer_qty_invoice`
                                INNER JOIN stock_purchase ON stock_purchase.s_id = customer_qty_invoice.prod_id
                                INNER JOIN batteries ON batteries.b_id = stock_purchase.battery_id
WHERE customer_qty_invoice.cus_id = '$id'  AND customer_qty_invoice.invoice_no = '$invoiceNo'");

$fetch_getInvoiceItems = mysqli_fetch_assoc($getInvoiceItems);

$getCustomerDetails = mysqli_query($connect, "SELECT * FROM `customer_add` WHERE c_id = '$id'");
$fetch_getCustomerDetails = mysqli_fetch_assoc($getCustomerDetails);

// $get

$getTotals = mysqli_query($connect, "SELECT * FROM `customer_summary_qty` WHERE c_id = '$id' AND invoice_id = '$invoiceNo'");
$fetch_getTotals = mysqli_fetch_assoc($getTotals);

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
    <div class="container-fluid"><br>
        <div class="row noPrint" id="printElement">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="invoice-title">
                            <h3 class="m-t-0 text-center">
                                <img src="../assets/ev-logo.png" width="100px" class="img-fluid" alt="Logo">
                                <h3 align="center" style="font-size: 150%;   font-family: Lucida Handwriting "><u><?php echo $fet['shop_title'] ?></u></h3>
                                <!-- <h3 align="center" style="font-size: 100%; line-height: 15px; font-family: Lucida Handwriting "><u><?php echo $fet['shop_name'] ?></u></h3> -->
                                <p class="text-center font-18" style="font-size: 100%; line-height: 10px;"><?php echo $fet['shop_address'] ?></p>
                                <br>
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin: -18px -15px !important;">
                    <div class="col-6">
                        <div class="invoice-title">
                            <p><u><b style="font-size: 100%;  line-height: 20px;">Customer Details</b></u></p>
                            <p class="text-left font-16 customP" style="font-size: 100%; line-height: 10px"><span style="font-weight:600">Name:</span> <?php echo $fetch_getCustomerDetails['customer_name'] ?></p>
                            <p class="text-left font-16 customP" style="font-size: 100%; line-height: 10px"><span style="font-weight:600">Address:</span> <?php echo $fetch_getCustomerDetails['customer_address'] ?></p>
                            <p class="text-left font-16 customP" style="font-size: 100%; line-height: 10px"><span style="font-weight:600">Contact:</span> <?php echo $fetch_getCustomerDetails['customer_contact'] ?></p>
                            <br>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="invoice-title text-right">
                            <p><u><b style="font-size: 100%;  line-height: 20px;">Billing Details</b></u></p>
                            <p class="text-right font-16 customP" style="font-size: 100%; line-height: 10px"><span style="font-weight:600">Invoice No: </span> EV-00<?php echo $invoiceNo ?></p>
                            <p class="text-right font-16 customP" style="font-size: 100%; line-height: 10px"><span style="font-weight:600">Bill Date: </span> <?php echo $fetch_getInvoiceItems['custom_date'] ?></p>
                            <p class="text-right font-16 customP" style="font-size: 100%; line-height: 10px"><span style="font-weight:600">Contact: </span> 0<?php echo $fet['shop_contact'] ?></p>
                            <p class="text-right font-16 customP" style="font-size: 100%; line-height: 10px"><span style="font-weight:600"></span> 0<?php echo $fet['shop_contact_two'] ?></p>
                            <br>
                        </div>
                    </div>
                </div>

                <!-- <div class="row" style="margin-top: -4%;">
                    <div class="col-md-12">
                        <h3 align="center" style="font-size: 120%">Invoice (Cash)</h3>
                    </div>
                </div> -->


                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">S#</th>

                                    <th scope="col">Product</th>
                                    
                                    <th scope="col">Price</th>
                                    
                                    <th scope="col">Discount</th>

                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $getInvoiceItemsLoop = mysqli_query($connect, "SELECT customer_qty_invoice.*, customer_qty_invoice.prod_qty AS qty, stock_purchase.*, batteries.battery_name, batteries.battery_warranty FROM `customer_qty_invoice`
                                INNER JOIN stock_purchase ON stock_purchase.s_id = customer_qty_invoice.prod_id
                                INNER JOIN batteries ON batteries.b_id = stock_purchase.battery_id
                                WHERE customer_qty_invoice.cus_id = '$id'  AND customer_qty_invoice.invoice_no = '$invoiceNo' GROUP BY customer_qty_invoice.prod_id");
                                
                                $getTotal = 0;

                                $itr = 1;

                                while ($row = mysqli_fetch_assoc($getInvoiceItemsLoop)) {
                                    



                                    echo '
                                    <tr>
                                        <td>' . $itr++ . ' </td>
                                        <td>' . $row['bike_model'] . '</td>
                                        <td>' . $row['prod_price'] . '</td>
                                        <td>' . $row['bike_sell_price'] - $row['prod_price'] . '</td>
                                        <td>' . $row['prod_price'] . '</td>
                                        ';



                                        $getTotal = $getTotal + $row['bike_sell_price'];

                                        // <td>' . $row['discount'] . ' %</td>
                                        // <td style="width: 15%">' . $tax . '</td>

                                        echo '
                                    </tr>
                                    ';
                                }



                                echo '
                                <tfoot style="border: none !important;">
                                    <tr>
                                        <td style="border: none; line-height: 1px !important"></td>
                                        <td style="border: none; line-height: 1px !important" class="text-left">Battery: '. $fetch_getInvoiceItems['battery_name'] .'</td>
                                        <td style="border: none; line-height: 1px !important"></td>
                                        <td style="border: none; line-height: 1px !important"></td>
                                        <td style="border: none; line-height: 1px !important"></td>
                                    </tr>

                                    <tr>
                                        <td style="border: none; line-height: 1px !important"></td>
                                        <td style="border: none; line-height: 1px !important" class="text-left">Warranty: '. $fetch_getInvoiceItems['battery_warranty'] .'</td>
                                        <td style="border: none; line-height: 1px !important"></td>
                                        <td style="border: none; line-height: 1px !important"></td>
                                        <td style="border: none; line-height: 1px !important"></td>
                                    </tr>
                                
                                    <tr style="border: none !important;">
                                        <td style="border: none; line-height: 1px !important"></td>
                                        <td style="border: none; line-height: 1px !important"></td>
                                        <td style="border: none; line-height: 1px !important"></td>
                                        <td style="border: none; line-height: 10px !important" class="text-right"><b>Sub Total: </td>
                                        <td style="border: none; line-height: 10px !important"><b>Rs. ' . number_format($fetch_getTotals['net_amount']) . '</b></td>
                                    </tr>

                                    <tr style="border: none !important;">
                                        <td style="border: none; line-height: 1px !important"></td>
                                        <td style="border: none; line-height: 1px !important"></td>
                                        <td style="border: none; line-height: 1px !important"></td>
                                        <td style="border: none; line-height: 10px !important" class="text-right"><b>Paid Total: </td>
                                        <td style="border: none; line-height: 10px !important"><b>Rs. ' . number_format($fetch_getTotals['paid_amount']) . '</b></td>
                                    </tr>

                                    <tr style="border: none !important;">
                                        <td style="border: none; line-height: 1px !important"></td>
                                        <td style="border: none; line-height: 1px !important"></td>
                                        <td style="border: none; line-height: 1px !important"></td>
                                        <td style="border: none; line-height: 10px !important" class="text-right"><b>Balance: </td>
                                        <td style="border: none; line-height: 10px !important"><b>Rs. ' . number_format($fetch_getTotals['remaining_amount']) . '</b></td>
                                    </tr>';
                                    

                                    $oldBalance = $fetch_getCustomerDetails['total_dues'] - $fetch_getTotals['remaining_amount'];


                                    if ($oldBalance > 0) {
                                        echo '
                                        <tr style="border: none !important;">
                                            <td style="border: none; line-height: 1px !important"></td>
                                            <td style="border: none; line-height: 1px !important"></td>
                                            <td style="border: none; line-height: 1px !important"></td>
                                            <td style="border: none; line-height: 10px !important;" class="text-right"><b>Old Balance: </td>
                                            <td style="border: none; line-height: 10px !important"><b>Rs. ' . $fetch_getCustomerDetails['total_dues'] - $fetch_getTotals['remaining_amount'] . '</b></td>
                                        </tr>

                                        <tr style="border: none !important;">
                                            <td style="border: none; line-height: 1px !important"></td>
                                            <td style="border: none; line-height: 1px !important"></td>
                                            <td style="border: none; line-height: 1px !important"></td>
                                            <td style="border: none; line-height: 10px !important;" class="text-right"><b>Total Balance: </td>
                                            <td style="border: none; line-height: 10px !important"><b>Rs. ' .$fetch_getCustomerDetails['total_dues'] . '</b></td>
                                        </tr>
                                        ';
                                    }
                                    

                                    echo '

                                    <tr style="border: none !important;">
                                        <td style="border: none; line-height: 1px !important"></td>
                                        <td style="border: none; line-height: 1px !important"></td>
                                        <td style="border: none; line-height: 1px !important"><img src="../assets/paid.png"  alt="Signature" style="margin-top: -100px; height: 100px; width: 100px;"></td>
                                        <td style="border: none; line-height: px !important" class="text-right"></td>
                                        <td style="border: none; line-height: px !important"></td>
                                    </tr>

                                </tfoot>
                                ';
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>




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