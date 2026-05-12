<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}


$c_id = $_GET['c_id'];

$getCartItems = mysqli_query($connect, "SELECT cart_tbl_qty.*,cart_tbl_qty.id AS cartID, cart_tbl_qty.id AS stockId, cart_tbl_qty.product_qty AS qty, stock_purchase.* FROM `cart_tbl_qty`
INNER JOIN stock_purchase ON stock_purchase.s_id = cart_tbl_qty.product_id
WHERE cart_tbl_qty.c_id = '$c_id' AND cart_tbl_qty.sell_status = '0' ORDER BY cart_tbl_qty.product_qty DESC");

if (isset($_POST['generatePdf'])) {
    $c_id             = $_POST['c_id'];
    $cart_id          = $_POST['cart_id'];
    $product_id       = $_POST['product_id'];
    $stock_id         = $_POST['stock_id'];
    $price            = $_POST['price'];
    $discount         = $_POST['discount'];
    $taxProduct       = $_POST['tax'];

    $totalAmount      = $_POST['totalAmount'];
    $paidAmount       = $_POST['paidAmount'];
    $remainingAmount  = $_POST['remainingAmount'];
    $discountAmount   = $_POST['discountAmount'];



    $invoiceNo = mysqli_query($connect, "SELECT MAX(invoice_no)AS invoiceNo FROM `customer_qty_invoice`");
    $fetch_invoiceNo = mysqli_fetch_assoc($invoiceNo);
    $invoice_no = $fetch_invoiceNo['invoiceNo'];

    if (empty($invoice_no) or $invoice_no === 'NULL') {
        $newInvoice = 1;
    } else {
        $newInvoice = $invoice_no + 1;
    }

    $updateStock = mysqli_query($connect, "UPDATE stock_purchase SET bike_status = '0' WHERE s_id = '$stock_id'");
    
    if ($updateStock) {
        $updateQuery = mysqli_query($connect, "UPDATE cart_tbl_qty SET sell_status = '1' WHERE product_id = '$product_id' AND c_id = '$c_id' AND id = '$cart_id'");

        if ($updateQuery) {
            $insertQuery = mysqli_query($connect, "INSERT INTO customer_qty_invoice(`cus_id`, `prod_id`, `prod_qty`, `prod_price`, `discount`, `tax`, `invoice_no`)VALUES('$c_id', '$product_id', '$product_qty', '$price', '$discount', '$taxProduct', '$newInvoice')");
        }
    }

    $getProfitData = mysqli_query($connect, "SELECT * FROM stock_purchase WHERE s_id = '$product_id'");
    $fetch_getProfitData = mysqli_fetch_assoc($getProfitData);
    $purchasePrice = $fetch_getProfitData['bike_purchase_price'];
    $profit = $price - $purchasePrice;


    date_default_timezone_set("Asia/Karachi");
    $customDate = date("Y-m-d");

    $insertProfit = mysqli_query($connect, "INSERT INTO profit_loss_qty(product_id, customer_id, custom_date, prod_qty_total, sold_price)VALUES('$product_id',  '$c_id', '$customDate', '$product_qty', '$price')");


    $insertSummaryQuery = mysqli_query($connect, "INSERT INTO `customer_summary_qty`(`c_id`, `invoice_id`, `net_amount`, `paid_amount`, `remaining_amount`, `net_discount`) VALUES ('$c_id', '$newInvoice', '$totalAmount', '$paidAmount', '$remainingAmount', '$discountAmount')");

    $updateCustomerData = mysqli_query($connect, "UPDATE customer_add SET total_sale = (total_sale + $totalAmount), total_paid = (total_paid + $paidAmount), total_dues = (total_dues + $remainingAmount) WHERE c_id = '$c_id'");

    if ($updateCustomerData) {
        $invoiceNoMax = mysqli_query($connect, "SELECT MAX(invoice_id) As inId FROM `customer_summary_qty` WHERE c_id = '$c_id'");
        $fetch_invoiceMaxId = mysqli_fetch_assoc($invoiceNoMax);
        $maxInvoice = $fetch_invoiceMaxId['inId'];
        header("LOCATION: print_invoice_qty.php?id=" . $c_id . "&invoiceNo=" . $maxInvoice . "");
    }
}


include('../_partials/header.php');
?>

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title"><i class="fa fa-shopping-cart "></i>&nbsp;&nbsp;Sell Bike (Generate Invoice)</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <form method="POST">
                            <div class="row text-right">
                                <div class="col-12 mb-4">
                                    <button type="submit" style="width: 30%" id="btnInvoice" name="generatePdf" class="btn btn-primary waves-effect waves-light btn-lg">Generate PDF</button>
                                </div>
                            </div>
                            <table class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $iteration = 1;
                                    $netPrice = 0;
                                    $discountAmount = 0;
                                    $getDiscountData = 0;
                                    $disc = 0;

                                    while ($rowCartItems = mysqli_fetch_assoc($getCartItems)) {
                                        echo '
                                        <input type="hidden" name="cart_id" value="' . $rowCartItems['cartID'] . '" class="form-control" required>
                                        <input type="hidden" name="c_id" value="' . $c_id . '" class="form-control" required>
                                        <input type="hidden" name="product_id" value="' . $rowCartItems['product_id'] . '" class="form-control" required>
                                        <input type="hidden" name="stock_id" value="' . $rowCartItems['stock_id'] . '" class="form-control" required>
                                        
                                        <input type="hidden" name="price" step=".01" value="' . $rowCartItems['price'] . '" class="form-control" required>
                                        <input type="hidden" name="product_qty" value="' . $rowCartItems['qty'] . '" class="form-control" required>
                                        <input type="hidden" name="discount" step=".01" value="' . $rowCartItems['discount'] . '" class="form-control" required>
                                        <input type="hidden" name="tax" step=".01" value="' . $rowCartItems['tax'] . '" class="form-control" required>
                                        ';

                                        $netDiscount = $rowCartItems['discount'];

                                        $discountAmount = $discountAmount + $netDiscount;

                                        $priceAfterDiscount = $rowCartItems['price'] - $rowCartItems['discount'];

                                        

                                        echo '
                                        <tr>
                                        
                                            <td>' . $iteration++ . '</td>
                                            <td><b>' . $rowCartItems['bike_model'] . '</b></td>
                                            <td><b>Rs. ' . $rowCartItems['price'] . '</b></td>
                                            ';

                                        // $total = $rowCartItems['qty'] * $priceAfterDiscount;
                                        $tax = $rowCartItems['qty'] * $rowCartItems['tax'];

                                        $total = ($rowCartItems['qty'] * $rowCartItems['price']) + $tax;

                                        $findingPercentage = ($rowCartItems['discount'] / 100) * $total;
                                        $findingPercentageFinal = round($findingPercentage, 2);


                                        // $total = ;
                                        $rowTotal = $rowCartItems['qty'] * $rowCartItems['price'];

                                        
                                        $disc = $rowCartItems['bike_sell_price'] - $rowCartItems['price'];
                                        $netPrice = $rowCartItems['price'];

                                        
                                        echo '
                                            <td><b>Rs. ' . $rowCartItems['price'] . '</b></td>';

                                        echo '</tr>
                                        ';
                                    }

                                    echo
                                    '<tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"><b>Total Amount:</b></td>
                                            <td><input type="number" name="totalAmount" readonly value="' . $netPrice . '" onkeyup="sum()" class="form-control pull-right" id="totalAmount" required=""></td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"><b>Discount:</b></td>
                                            <td><input type="number" name="discountAmount" readonly value="'.$disc.'" onkeyup="sum()" class="form-control pull-right" id="discountAmount" required=""></td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"><b>Paid Amount:</b></td>
                                            <td><input type="number" name="paidAmount" onkeyup="sum()" value="0" class="form-control pull-right" step=".01" id="paidAmount" required=""></td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"><b>Remaining Amount:</b></td>
                                            <td><input  readonly name="remainingAmount" onkeyup="sum()" class="form-control pull-right"  step=".01"  id="remainingAmount" required=""></td>
                                        </tr>
                                    </tfoot>';
                                    ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div><!-- container fluid -->
</div> <!-- Page content Wrapper -->
</div> <!-- content -->
<?php include('../_partials/footer.php') ?>
</div>
<!-- End Right content here -->
</div>
<!-- END wrapper -->
<!-- jQuery  -->
<?php include('../_partials/jquery.php') ?>
<!-- Required datatable js -->
<?php include('../_partials/datatable.php') ?>
<!-- Datatable init js -->
<?php include('../_partials/datatableInit.php') ?>
<!-- Buttons examples -->
<?php include('../_partials/buttons.php') ?>
<!-- App js -->
<?php include('../_partials/app.php') ?>
<!-- Responsive examples -->
<?php include('../_partials/responsive.php') ?>
<!-- Sweet-Alert  -->
<?php include('../_partials/sweetalert.php') ?>

<script>
    $(document).ready(function() {
        // Run calculation immediately on page load
        calculateRemaining();

        // Listen for changes in any relevant field
        $('#discountAmount, #paidAmount, #totalAmount').on('input', function() {
            calculateRemaining();
        });

        function calculateRemaining() {
            var total = parseFloat($('#totalAmount').val()) || 0;
            var discount = parseFloat($('#discountAmount').val()) || 0;
            var paid = parseFloat($('#paidAmount').val()) || 0;

            var remaining = total -  paid;

            // Update the display field
            $('#remainingAmount').val(remaining);

            // Logic: Disable button if Remaining Amount is negative
            if (remaining < 0) {
                $('#btnInvoice').prop('disabled', true);
                $('#btnInvoice').css('opacity', '0.5'); // Visual cue that it's disabled
                $('#remainingAmount').css('color', 'red'); // Optional: turn text red
            } else {
                $('#btnInvoice').prop('disabled', false);
                $('#btnInvoice').css('opacity', '1');
                $('#remainingAmount').css('color', 'black');
            }
        }
    });
</script>

</body>

</html>