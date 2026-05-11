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

if (isset($_POST['update'])) {
    $id = $_POST['id'];

    $getOldFileName = mysqli_query($connect, "SELECT * FROM stock_purchase WHERE s_id = '$id'");
    $fetchOldFileName = mysqli_fetch_assoc($getOldFileName);

    $unlinkFile = "../__images/".$fetchOldFileName['bike_image'];

    unlink($unlinkFile);

    $DP = $_FILES['bike_image']['name'];
    if (empty($DP)) {
        $userNotAdded = "<div class='alert alert-primary' role='alert'>Record Not Updated! Please select an image and try again.</div>";
    }else {
        $profile= $_FILES['bike_image'];
        $profile_name= $profile['name'];
        $profile_name= preg_replace("/\s+/", "", $profile_name);
        $profileTemp= $profile['tmp_name'];

        $profile_ext=pathinfo($profile_name,PATHINFO_EXTENSION);
        $profile_name=pathinfo($profile_name,PATHINFO_FILENAME);

        $profileNewName = $profile_name.date("miYis").'.'.$profile_ext;

        $saveProfileImage = "../__images/".$profileNewName;

        if (move_uploaded_file($profileTemp, $saveProfileImage)) {
            // echo "Done";
        }else{
            echo "Error Profile Image Uploading";
        }

        $insertStock = mysqli_query($connect, "UPDATE stock_purchase SET bike_image='$profileNewName' WHERE s_id='$id'");

        if (!$insertStock) {
            $userNotAdded = "<div class='alert alert-primary' role='alert'>Image not added! Try Again.</div>";
        }else{
            header("LOCATION: stock_purchase_view.php?id=".$id."");
        }
    }
}


include('../_partials/header.php');
?>
<style>
    .customImageStyle:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        transition: ease 1s;
    }
</style>
<script src="../assets/imgconvertor.js"></script>
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
                        <div class="row">
                            <div class="col-6 align-self-center">
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <img src="<?php echo "../__images/".$rowBikes['bike_image']; ?>" alt="Bike Image" class="customImageStyle img-fluid mb-3" style="max-width: 100%; height: contain;">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="file"  name="bike_image" class="form-control" required />
                                        </div>
                                        <div class="col-6 text-right">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light" name="update">Update Image</button>
                                        </div>
                                    </div>
                                </form>
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
                                            <th>Purchase Price</th>
                                            <th><?php echo number_format($rowBikes['bike_purchase_price']); ?></th>
                                        </tr>

                                        <tr>
                                            <th>Sell Price</th>
                                            <th><?php echo number_format($rowBikes['bike_sell_price']); ?></th>
                                        </tr>

                                        <tr>
                                            <th>Battery</th>
                                            <th><?php echo $rowBikes['battery_name']; ?></th>
                                        </tr>

                                        <tr>
                                            <th>Battery Warranty</th>
                                            <th><?php echo $rowBikes['battery_warranty']; ?></th>
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