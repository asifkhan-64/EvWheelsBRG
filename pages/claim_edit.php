<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$alreadyAdded = '';
$added = '';
$error = '';

$id = $_GET['id'];
$queryGetClaim = mysqli_query($connect, "SELECT * FROM claims WHERE cl_id = '$id'");
$fetchClaim = mysqli_fetch_assoc($queryGetClaim);

if (isset($_POST['editClaim'])) {
    $customer_id = $_POST['customer_id'];
    $chassis_number = $_POST['chassis_number'];
    $claim_date = $_POST['claim_date'];
    $part_id = $_POST['part_id'];
    $claim_qty = $_POST['claim_qty'];

    $id = $_GET['id'];

    $checkClaimQuery = mysqli_query($connect, "SELECT * FROM claims WHERE cl_id = '$id'");
    $fetchClaimQuery = mysqli_fetch_assoc($checkClaimQuery);

    $prevQty = $fetchClaimQuery['claim_qty'];

    if ($claim_qty > $prevQty) {
        $findDifference = $claim_qty - $prevQty;

        $updatePartTbl = mysqli_query($connect, "UPDATE parts SET claimed = claimed + '$findDifference' WHERE p_id = '$part_id'");

        if ($updatePartTbl) {
            $updateClaimTBl = mysqli_query($connect, "UPDATE claims SET customer_id = '$customer_id', chassis_number = '$chassis_number', claim_date = '$claim_date', part_id = '$part_id', claim_qty = '$claim_qty' WHERE cl_id = '$id'");
        
            if (!$updateClaimTBl) {
                $error = '<div class="alert alert-alert" role="alert">Claim Not Updated! Try again!</div>';
            } else {
                header("LOCATION:claims_list.php");
            }
        }
    } elseif ($claim_qty < $prevQty) {
        $findDifference = $prevQty - $claim_qty;

        $updatePartTbl = mysqli_query($connect, "UPDATE parts SET claimed = claimed - '$findDifference' WHERE p_id = '$part_id'");
        if ($updatePartTbl) {
            $updateClaimTBl = mysqli_query($connect, "UPDATE claims SET customer_id = '$customer_id', chassis_number = '$chassis_number', claim_date = '$claim_date', part_id = '$part_id', claim_qty = '$claim_qty' WHERE cl_id = '$id'");
            
            if (!$updateClaimTBl) {
                $error = '<div class="alert alert-alert" role="alert">Claim Not Updated! Try again!</div>';
            } else {
                header("LOCATION:claims_list.php");
            }
        }
    }else {
        $updateClaimTBl = mysqli_query($connect, "UPDATE claims SET customer_id = '$customer_id', chassis_number = '$chassis_number', claim_date = '$claim_date', part_id = '$part_id', claim_qty = '$claim_qty' WHERE cl_id = '$id'");
            
        if (!$updateClaimTBl) {
            $error = '<div class="alert alert-alert" role="alert">Claim Not Updated! Try again!</div>';
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
                <h5 class="page-title"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;Claim Edit</h5>
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
                                            if ($rowCustomer['c_id'] == $fetchClaim['customer_id']) {
                                                $selected = 'selected';
                                            } else {
                                                $selected = '';
                                            }
                                            echo '
                                            <option value="' . $rowCustomer['c_id'] . '" ' . $selected . '>' . $rowCustomer['customer_name'] . '</option>
                                            ';
                                        }
                                        ?>
                                    </select>
                                </div>


                                <label for="example-text-input" class="col-sm-2 col-form-label">Chassis #</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Chassis Number" type="text" value="<?php echo $fetchClaim['chassis_number']; ?>" id="example-text-input" name="chassis_number" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Date</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Date" type="date" value="<?php echo $fetchClaim['claim_date']; ?>" id="example-text-input" name="claim_date" required="">
                                </div>


                                <label class="col-sm-2 col-form-label">Claim Item (Parts)</label>
                                <div class="col-sm-4">
                                    <select class="form-control designation" name="part_id" required="" style="width:100%">
                                        <?php
                                        $getCustomerQuery = mysqli_query($connect, "SELECT * FROM parts");

                                        echo '<option value="" disabled selected>Select Warranty</option>';
                                        
                                        while ($rowCustomer = mysqli_fetch_assoc($getCustomerQuery)) {
                                            if ($rowCustomer['p_id'] == $fetchClaim['part_id']) {
                                                $selected = 'selected';
                                            } else {
                                                $selected = '';
                                            }
                                            echo '
                                            <option value="' . $rowCustomer['p_id'] . '" ' . $selected . '>' . $rowCustomer['part_name'] . '</option>
                                            ';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Qty</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Qty" type="number" value="<?php echo $fetchClaim['claim_qty']; ?>" id="example-text-input" name="claim_qty" required="">
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <!-- <label for="example-password-input" class="col-sm-2 col-form-label"></label> -->
                                <div class="col-sm-12" align="right">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="editClaim">Edit Claim</button>
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