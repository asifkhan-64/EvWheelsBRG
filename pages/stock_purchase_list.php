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
                <h5 class="page-title"><i class="fa-solid fa-motorcycle"></i>&nbsp;&nbsp;Purchase List</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Purchase List</h4>

                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Model</th>
                                    <th>Color</th>
                                    <th>Purchse</th>
                                    <th>Sell</th>
                                    <th>Battery</th>
                                    <th>Average</th>
                                    <th class="text-center"> <i class="fa fa-edit"></i>
                                    <th class="text-center"> <i class="fa fa-eye"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $retBikes = mysqli_query($connect, "SELECT stock_purchase.*, batteries.battery_name, batteries.battery_warranty FROM `stock_purchase`
                                INNER JOIN batteries ON batteries.b_id = stock_purchase.battery_id;");
                                $iteration = 1;

                                while ($rowBikes = mysqli_fetch_assoc($retBikes)) {
                                    echo '
                                    <tr>
                                        <td>' . $iteration++ . '</td>
                                        <td>' . $rowBikes['bike_model'] . '</td>
                                        <td>' . $rowBikes['bike_color'] . '</td>
                                        <td>' . $rowBikes['bike_purchase_price'] . '</td>
                                        <td>' . $rowBikes['bike_sell_price'] . '</td>
                                        <td>' . $rowBikes['battery_name'] . '</td>
                                        <td>' . $rowBikes['bike_average'] . '</td>
                                        <td class="text-center"><a href="stock_purchase_edit.php?id=' . $rowBikes['s_id'] . '" type="button" class="btn text-white btn-warning waves-effect waves-light">Edit</a></td>
                                        <td class="text-center"><a href="stock_purchase_view.php?id=' . $rowBikes['s_id'] . '" type="button" class="btn text-white btn-info waves-effect waves-light">View</a></td>
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