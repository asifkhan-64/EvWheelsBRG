<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$alreadyAdded = '';
$added = '';
$error = '';

if (isset($_POST['addClaim'])) {
    $customer_id = $_POST['customer_id'];
    $chassis_number = $_POST['chassis_number'];
    $claim_date = $_POST['claim_date'];
    $part_id = $_POST['part_id'];
    $claim_qty = $_POST['claim_qty'];

    $updatePartTbl = mysqli_query($connect, "UPDATE parts SET claimed = claimed + '$claim_qty' WHERE p_id = '$part_id'");

    if ($updatePartTbl) {
        $insertClaimTBl = mysqli_query($connect, "INSERT INTO claims(customer_id, chassis_number, claim_date, part_id, claim_qty)VALUES('$customer_id', '$chassis_number', '$claim_date', '$part_id', '$claim_qty')");
    
        if (!$insertClaimTBl) {
            $error = '<div class="alert alert-alert" role="alert">Claim Not Added! Try again!</div>';
        } else {
            header("LOCATION:claims_list.php");
        }
    }
}


include('../_partials/header.php');
?>

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;Claim Add</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Customer</label>
                                <div class="col-sm-4">
                                    <select class="form-control designation" name="customer_id" required="" style="width:100%">
                                        <?php
                                        $getCustomerQuery = mysqli_query($connect, "SELECT * FROM customer_add");

                                        echo '<option value="" disabled selected>Select Warranty</option>';
                                        
                                        while ($rowCustomer = mysqli_fetch_assoc($getCustomerQuery)) {
                                            echo '
                                            <option value="' . $rowCustomer['c_id'] . '">' . $rowCustomer['customer_name'] . '</option>
                                            ';
                                        }
                                        ?>
                                    </select>
                                </div>


                                <label for="example-text-input" class="col-sm-2 col-form-label">Chassis #</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Chassis Number" type="text" value="" id="example-text-input" name="chassis_number" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Date</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Date" type="date" value="" id="example-text-input" name="claim_date" required="">
                                </div>


                                <label class="col-sm-2 col-form-label">Claim Item (Parts)</label>
                                <div class="col-sm-4">
                                    <select class="form-control designation" name="part_id" required="" style="width:100%">
                                        <?php
                                        $getCustomerQuery = mysqli_query($connect, "SELECT * FROM parts");

                                        echo '<option value="" disabled selected>Select Warranty</option>';
                                        
                                        while ($rowCustomer = mysqli_fetch_assoc($getCustomerQuery)) {
                                            echo '
                                            <option value="' . $rowCustomer['p_id'] . '">' . $rowCustomer['part_name'] . '</option>
                                            ';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Qty</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Qty" type="number" value="" id="example-text-input" name="claim_qty" required="">
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <!-- <label for="example-password-input" class="col-sm-2 col-form-label"></label> -->
                                <div class="col-sm-12" align="right">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="addClaim">Add Claim</button>
                                </div>
                            </div>
                        </form>
                        <h5 align="center"><?php echo $error ?></h5>
                        <h5 align="center"><?php echo $added ?></h5>
                        <h5 align="center"><?php echo $alreadyAdded ?></h5>
                    </div>
                </div>
            </div>
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
<script type="text/javascript" src="../assets/js/select2.min.js"></script>
<script type="text/javascript">
$('.designation').select2({
    placeholder: 'Select an option',
    allowClear: true

});

$('.attendant').select2({
    placeholder: 'Select an option',
    allowClear: true

});

$('.payment').select2({
        placeholder: 'Select an option',
        allowClear: true

    });
</script>
</body>

</html>