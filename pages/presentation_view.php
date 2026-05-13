<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}



$id = $_GET['id'];

$retBikes = mysqli_query($connect, "SELECT stock_purchase.*, batteries.battery_name, batteries.battery_warranty FROM `stock_purchase`
            INNER JOIN batteries ON batteries.b_id = stock_purchase.battery_id
            WHERE stock_purchase.s_id = '$id'");

$rowBikes = mysqli_fetch_assoc($retBikes);

$get = mysqli_query($connect, "SELECT * FROM `shop_info`");
$fet = mysqli_fetch_assoc($get);

?>

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
    <link rel="stylesheet" href="../assets/plugins/morris/morris.css">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css">

    <link href="../assets/package/dist/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <!-- DataTables -->
    <link href="../assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="../assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/customStyles.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style1.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-slider.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-datepicker.min.css">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />

    <script src='../assets/kit.js' crossorigin='anonymous'></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->

    <style>
    .customImageStyle {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        transition: ease 1s;
    }
</style>
</head>

<script src="../assets/imgconvertor.js"></script>
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h5 class="page-title"><i class="fa-solid fa-motorcycle"></i>&nbsp;&nbsp;EV Bike (View)</h5>
            </div>

            <div class="col-sm-6 text-right pt-2">
                <a href="presentation.php" class="btn btn-secondary waves-effect waves-light"><i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 align-self-center">
                                <img src="<?php echo "../__images/".$rowBikes['bike_image']; ?>" alt="Bike Image" class="customImageStyle img-fluid mb-3" style="max-width: 100%; height: contain;"> 
                            </div>


                            <div class="col-6">
                                <table  class="table dt-responsive nowrap" style=" width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Model</th>
                                            <th><?php echo $rowBikes['bike_model']; ?></th>
                                        </tr>

                                        <tr>
                                            <th>Color</th>
                                            <th><?php echo $rowBikes['bike_color']; ?></th>
                                        </tr>

                                        <tr>
                                            <th>Chassis No</th>
                                            <th><?php echo $rowBikes['bike_chassis_no']; ?></th>
                                        </tr>


                                        <tr>
                                            <th>Sell Price</th>
                                            <th>Pkr. <?php echo number_format($rowBikes['bike_sell_price']); ?></th>
                                        </tr>

                                        <tr>
                                            <th>Battery</th>
                                            <th><?php echo $rowBikes['battery_name']; ?> - Warranty: <?php echo $rowBikes['battery_warranty']; ?></th>
                                        </tr>

                                        <tr>
                                            <th>Battery V/A</th>
                                            <th><?php echo $rowBikes['battery_voltage'] . 'V / A'; ?></th>
                                        </tr>

                                        <tr>
                                            <th>Battery Watt</th>
                                            <th><?php echo $rowBikes['bike_watt']; ?></th>
                                        </tr>


                                        <tr>
                                            <th>Average</th>
                                            <th><?php echo $rowBikes['bike_average']; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div><!-- container fluid -->
</div> <!-- Page content Wrapper -->
</div> <!-- content -->

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

    document.querySelector('input[name="bike_image"]').addEventListener('change', async function (e) {
    const file = e.target.files[0];
    
    if (!file) return;

    // Check if the file is HEIC
    const fileName = file.name.toLowerCase();
    if (fileName.endsWith(".heic") || fileName.endsWith(".heif")) {
        
        console.log("HEIC detected. Converting...");
        
        try {
            // Perform conversion
            const conversionResult = await heic2any({
                blob: file,
                toType: "image/jpeg",
                quality: 0.8
            });

            // Create a new File object from the converted Blob
            const newFileName = file.name.replace(/\.[^/.]+$/, "") + ".jpg";
            const convertedFile = new File([conversionResult], newFileName, {
                type: "image/jpeg",
                lastModified: new Date().getTime()
            });

            // Replace the file in the input field using DataTransfer
            const container = new DataTransfer();
            container.items.add(convertedFile);
            e.target.files = container.files;

            console.log("Conversion successful: " + newFileName);
            alert("iPhone image converted to JPG automatically.");

        } catch (error) {
            console.error("Conversion failed:", error);
            alert("Could not convert HEIC file. Please try a standard JPG.");
        }
    }
});
</script>
</body>

</html>