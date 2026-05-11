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
$retBikes = mysqli_query($connect, "SELECT stock_purchase.*, batteries.battery_name, batteries.battery_warranty FROM `stock_purchase`
            INNER JOIN batteries ON batteries.b_id = stock_purchase.battery_id
            WHERE stock_purchase.s_id = '$id'");
            
$rowBikes = mysqli_fetch_assoc($retBikes);

if (isset($_POST['updateBike'])) {
    $bike_model = $_POST['bike_model'];
    $bike_color = $_POST['bike_color'];
    $bike_chassis_no = $_POST['bike_chassis_no'];
    $bike_purchase_date = $_POST['bike_purchase_date'];
    $bike_purchase_price = $_POST['bike_purchase_price'];
    $bike_sell_price = $_POST['bike_sell_price'];
    $battery_id = $_POST['battery_id'];
    $battery_voltage = $_POST['battery_voltage'];
    $bike_watt = $_POST['bike_watt'];
    $bike_average = $_POST['bike_average'];

    
    $insertStock = mysqli_query($connect, "UPDATE stock_purchase SET bike_model='$bike_model', bike_color='$bike_color', bike_chassis_no='$bike_chassis_no', bike_purchase_date='$bike_purchase_date', bike_purchase_price='$bike_purchase_price', bike_sell_price='$bike_sell_price', battery_id='$battery_id', battery_voltage='$battery_voltage', bike_watt='$bike_watt', bike_average='$bike_average' WHERE s_id='$id'");

    if (!$insertStock) {
        $userNotAdded = "<div class='alert alert-primary' role='alert'>Image not added! Try Again.</div>";
    }else{
        header("LOCATION: stock_purchase_list.php");
    }
    
}


include('../_partials/header.php');
?>

<script src="../assets/imgconvertor.js"></script>


<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title"><i class="fa-solid fa-motorcycle"></i>&nbsp;&nbsp;Purchase Edit</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Model</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Model" type="text" value="<?php echo $rowBikes['bike_model']; ?>" id="example-text-input" name="bike_model" required="">
                                </div>

                                <label for="example-text-input" class="col-sm-2 col-form-label">Color</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Color" type="text" value="<?php echo $rowBikes['bike_color']; ?>" id="example-text-input" name="bike_color" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Chassis No</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Chassis No" type="text" value="<?php echo $rowBikes['bike_chassis_no']; ?>" id="example-text-input" name="bike_chassis_no" required="">
                                </div>

                                <label for="example-text-input" class="col-sm-2 col-form-label">Purchase Date</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Purchase Date" type="date" value="<?php echo $rowBikes['bike_purchase_date']; ?>" id="example-text-input" name="bike_purchase_date" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Purchase Price</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Purchase Price" type="number" value="<?php echo $rowBikes['bike_purchase_price']; ?>" id="example-text-input" name="bike_purchase_price" required="">
                                </div>


                                <label for="example-text-input" class="col-sm-2 col-form-label">Sell Price</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Sell Price" type="number" value="<?php echo $rowBikes['bike_sell_price']; ?>" id="example-text-input" name="bike_sell_price" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Battery</label>
                                <div class="col-sm-4">
                                    <select class="form-control designation" name="battery_id" required="" style="width:100%">
                                        <?php
                                        $getCustomerQuery = mysqli_query($connect, "SELECT * FROM batteries");

                                        echo '<option value="" disabled selected>Select Battery</option>';
                                        
                                        while ($rowCustomer = mysqli_fetch_assoc($getCustomerQuery)) {
                                            echo '
                                            <option value="' . $rowCustomer['b_id'] . '"' . ($rowCustomer['b_id'] == $rowBikes['battery_id'] ? ' selected' : '') . '>' . $rowCustomer['battery_name'] . '</option>
                                            ';
                                        }
                                        ?>
                                    </select>
                                </div>


                                <label for="example-text-input" class="col-sm-2 col-form-label">Battery V/A</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Battery V/A" type="text" value="<?php echo $rowBikes['battery_voltage']; ?>" id="example-text-input" name="battery_voltage" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Watt</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Watt" type="text" value="<?php echo $rowBikes['bike_watt']; ?>" id="example-text-input" name="bike_watt" required="">
                                </div>

                                <label for="example-text-input" class="col-sm-2 col-form-label">Average</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Average" type="text" value="<?php echo $rowBikes['bike_average']; ?>" id="example-text-input" name="bike_average" required="">
                                </div>
                            </div>


                            <hr>

                            <div class="form-group row">
                                <!-- <label for="example-password-input" class="col-sm-2 col-form-label"></label> -->
                                <div class="col-sm-12" align="right">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="updateBike">Update Purchase</button>
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

    document.querySelector('input[name="fileUpload"]').addEventListener('change', async function (e) {
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