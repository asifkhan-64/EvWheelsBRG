<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$alreadyAdded = '';
$added = '';
$error = '';

$b_id = $_GET['id'];
$queryGetBattery = mysqli_query($connect, "SELECT * FROM batteries WHERE b_id = '$b_id'");
$fetchBattery = mysqli_fetch_assoc($queryGetBattery);

if (isset($_POST['editBattery'])) {
    $battery_name = $_POST['battery_name'];
    $battery_warranty = $_POST['battery_warranty'];
    $battery_id = $_POST['battery_id'];

    
    $updateQuery = mysqli_query($connect, "UPDATE batteries SET battery_name = '$battery_name', battery_warranty = '$battery_warranty' WHERE b_id = '$battery_id'");
    if (!$updateQuery) {
        $error = 'Not Updated! Try again!';
    } else {
        header("LOCATION:battery_add.php");
    }
    
}


include('../_partials/header.php');
?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Battery Type Edit</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Battery Name" type="text" value="<?php echo $fetchBattery['battery_name'] ?>" id="example-text-input" name="battery_name" required="">
                                </div>

                                <input class="form-control" type="hidden" value="<?php echo $fetchBattery['b_id'] ?>" name="battery_id">

                                <label class="col-sm-2 col-form-label">Warranty</label>
                                <div class="col-sm-4">
                                    <select class="form-control designation" name="battery_warranty" required="" style="width:100%">
                                        <?php $selectedWarranty = $fetchBattery['battery_warranty']; ?>
                                        <option value="" disabled>Select Warranty</option>
                                        <option value="1-Year" <?php echo ($selectedWarranty == '1-Year') ? 'selected' : '' ?>>1-Year</option>
                                        <option value="2-Years" <?php echo ($selectedWarranty == '2-Years') ? 'selected' : '' ?>>2-Years</option>
                                        <option value="3-Years" <?php echo ($selectedWarranty == '3-Years') ? 'selected' : '' ?>>3-Years</option>
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <!-- <label for="example-password-input" class="col-sm-2 col-form-label"></label> -->
                                <div class="col-sm-12" align="right">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="editBattery">Edit Battery</button>
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