<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$alreadyAdded = '';
$added = '';
$error = '';

if (isset($_POST['addBattery'])) {
    $battery_name = $_POST['battery_name'];
    $battery_warranty = $_POST['battery_warranty'];

    $countQuery = mysqli_query($connect, "SELECT COUNT(*)AS countedBattries FROM batteries WHERE battery_name = '$battery_name'");
    $fetch_countQuery = mysqli_fetch_assoc($countQuery);


    if ($fetch_countQuery['countedBattries'] == 0) {
        $insertQuery = mysqli_query($connect, "INSERT INTO batteries(battery_name, battery_warranty)VALUES('$battery_name', '$battery_warranty')");
        if (!$insertQuery) {
            $error = 'Not Added! Try again!';
        } else {
            $added = '
                <div class="alert alert-primary" role="alert">
                                Battery Type Added!
                             </div>';
        }
    } else {
        $alreadyAdded = '<div class="alert alert-dark" role="alert">
                                Battery Type Already Added!
                             </div>';
    }
}


include('../_partials/header.php');
?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title"><i class="fa fa-check-circle"></i>&nbsp; EV Claims (Received)</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Received Claims List</h4>

                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Chassis #</th>
                                    <th>Claim</th>
                                    <th>Qty</th>
                                    <th>Claim Date</th>
                                    <th>Status</th>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $retClaims = mysqli_query($connect, "SELECT claims.*, customer_add.customer_name, customer_add.customer_contact, customer_add.customer_address, customer_add.customer_cnic, parts.part_name FROM `claims`
                                INNER JOIN customer_add ON customer_add.c_id = claims.customer_id
                                INNER JOIN parts ON parts.p_id = claims.part_id
                                WHERE claims.claim_status = '0' ORDER BY claims.claim_date DESC");
                                $iteration = 1;

                                while ($rowClaims = mysqli_fetch_assoc($retClaims)) {
                                    echo '
                                    <tr>
                                        <td>' . $iteration++ . '</td>
                                        <td>' . $rowClaims['customer_name'] . '</td>
                                        <td>' . $rowClaims['chassis_number'] . '</td>
                                        <td>' . $rowClaims['part_name'] . '</td>
                                        <td>' . $rowClaims['claim_qty'] . '</td>
                                        <td>' . $rowClaims['claim_date'] . '</td>';

                                        if ($rowClaims['claim_status'] == '1') {
                                            echo '<td><span class="p-3 badge badge-warning">Pending</span></td>';
                                        } else if ($rowClaims['claim_status'] == '0') {
                                            echo '<td><span class="p-3 badge badge-success">Received</span></td>';
                                        }
                                        echo '
                                    </tr>
                                    ';
                                }
                                ?>
                            </tbody>
                        </table>
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