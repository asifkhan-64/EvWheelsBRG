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

$queryGetClaim = mysqli_query($connect, "SELECT claims.*, customer_add.customer_name, customer_add.customer_contact, customer_add.customer_address, customer_add.customer_cnic, parts.part_name FROM `claims`
                                INNER JOIN customer_add ON customer_add.c_id = claims.customer_id
                                INNER JOIN parts ON parts.p_id = claims.part_id
                                WHERE claims.cl_id = '$id'");

$fetchClaim = mysqli_fetch_assoc($queryGetClaim);

if (isset($_POST['editClaim'])) {
    $cl_id = $_POST['claim_id'];
    $part_id = $_POST['part_id'];
    $claim_qty = $_POST['claim_qty'];

    $updateClaim = mysqli_query($connect, "UPDATE claims SET claim_status = '0' WHERE cl_id = '$cl_id'");
    if ($updateClaim) {
        $updatePartTbl = mysqli_query($connect, "UPDATE parts SET claimed = claimed - '$claim_qty', received = received + '$claim_qty' WHERE p_id = '$part_id'");

        $insertReceived = mysqli_query($connect, "INSERT INTO claims_received(claim_id) VALUES ('$cl_id')");
        if ($updatePartTbl) {
            header("LOCATION: claims_list.php");
        }
    } else {
        $error = "<div class='alert alert-danger text-center'>Error updating claim status.</div>";
    }
    

    
    
}


include('../_partials/header.php');
?>

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;Claim (Claim Received)</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row text-center">
                                <h3 class="col-12 text-center"><q>Do you want to change the status of this claim and mark it as complete?</q></h3>
                            </div>

                            <input type="text" name="claim_id" value="<?php echo $id; ?>" hidden>
                            <input type="text" name="part_id" value="<?php echo $fetchClaim['part_id']; ?>" hidden>
                            <input type="text" name="claim_qty" value="<?php echo $fetchClaim['claim_qty']; ?>" hidden>

                            <hr>
                            
                            <div class="form-group row text-center">
                                <p class="col-2"></p>
                                <p class="col-5 text-left"><strong>Name: </strong><?php echo $fetchClaim['customer_name'] ?></p>
                                <p class="col-5 text-left"><strong>Contact: </strong><?php echo $fetchClaim['customer_contact'] ?></p>
                                <p class="col-2"></p>
                                <p class="col-5 text-left"><strong>Address: </strong><?php echo $fetchClaim['customer_address'] ?></p>
                                <p class="col-5 text-left"><strong>CNIC: </strong><?php echo $fetchClaim['customer_cnic'] ?></p>
                                <p class="col-2"></p>
                                <p class="col-5 text-left"><strong>Claim: </strong><?php echo $fetchClaim['part_name'] ?></p>
                                <p class="col-5 text-left"><strong>Quantity: </strong><?php echo $fetchClaim['claim_qty'] ?></p>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <!-- <label for="example-password-input" class="col-sm-2 col-form-label"></label> -->
                                <div class="col-sm-12" align="center">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="editClaim">Claim Received</button>
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