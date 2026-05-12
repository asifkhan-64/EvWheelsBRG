<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$output = '';
$no_models = '';

$searchTags = $_POST["searchTags"];
$modified = "%$searchTags%";

$query = mysqli_query($connect, "SELECT * FROM `stock_purchase` WHERE bike_status = '1' AND (bike_model LIKE '$modified')");
$rowcount = mysqli_num_rows($query);
if ($rowcount < 1) {
    $output .= '
        <h3>No Product Found!</h3>
    ';
} else {
    while ($rowStock = mysqli_fetch_array($query)) {
        $output .= '
            <div class="form-element p-1">
            <input type="radio" name="platform" value="' . $rowStock['s_id'] . '" id="' . $rowStock['bike_model'] . '">
            <label for="' . $rowStock['bike_model'] . '">

                <div class="icon p-1">
                    <img src="../__images/' . $rowStock['bike_image'] . '" width="100%" class="img-fluid img-thumbnail" style="box-shadow: 0 0 10px rgba(0,0,0,0.3); border-radius: 10px;" height="100%" alt="">
                </div>
                
                <div class="title pt-3">
                ' . $rowStock['s_id'] . ' - ' . $rowStock['bike_model'] . '
                </div>

                <p class="title">Price: ' . $rowStock['bike_sell_price'] . '</p>
                
            </label>
            </div>
        ';
    }
}


echo $output;
