<?php
include('../_stream/config.php');
$sesssionEmail = $_SESSION["user"];

if (empty($sesssionEmail)) {
    header("LOCATION: ../index.php");
}
$query = mysqli_query($connect, "SELECT user_role FROM login_user WHERE email = '$sesssionEmail' ");
$fetch_query = mysqli_fetch_assoc($query);

$get = mysqli_query($connect, "SELECT * FROM `shop_info`");
$fet = mysqli_fetch_assoc($get);


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?php echo $fet['shop_title']; ?></title>
    <meta content="<?php echo $fet['shop_title']; ?>" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- <link rel="shortcut icon" href="../assets/LogoFinal.png"> -->
    <link rel="shortcut icon" href="../assets/logo.png">
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

    <style>

    /* 1. Define the Keyframes for the Animation */
        @keyframes float {
        0% {
            transform: translateY(0); /* Start position */
        }
        50% {
            transform: translateY(-10px); /* Move up 5 pixels */
        }
        100% {
            transform: translateY(0); /* Return to start */
        }
        }

        /* 2. Apply the Animation to the Cards */
        .timeline-content {
        /* ... existing styles like box-shadow ... */
        animation: float 4s ease-in-out infinite !important; /* Apply the animation */
        zoon: 0.5 !important;
        }

        .timeline  {
            animation-delay: 1s !important; /* Start half a second later */
        }

        .main-timeline2 .timeline:nth-child(2) .timeline-content {
        animation-delay: 0.5s !important; /* Start half a second later */
        }

        .main-timeline2 .timeline:nth-child(3) .timeline-content {
        animation-delay: 0.5s !important; /* Start one second later */
        }

        body {
            font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif; 
        }

        .my-element {
            display: inline-block;
            margin: 0 0.5rem;

            animation: Fade; /* referring directly to the animation's @keyframe declaration */
            animation-duration: 2s; /* don't forget to set a duration! */
        }

            /* This only changes this particular animation duration */
        .animate__animated.animate__bounce {
            --animate-duration: 2s;
        }

            /* This changes all the animations globally */
        :root {
            --animate-duration: 800ms;
            --animate-delay: 1s;
        }




        /* For image */


        img {
            transition: transform 0.5s ease; /* Adjust duration and timing as needed */
            
        }

        img:hover {
            transform: scale(1.2); /* Grows by 20% */
            /* background-color: rgba(255, 255, 255, 0.5); */
            /* rotate: -10deg; */
            backdrop-filter: blur(100px); /* Apply a blur of 10 pixels */
            -webkit-backdrop-filter: blur(10px); /* For Webkit-based browsers */
        }
    </style>

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
</head>

<body class="fixed-left">
    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- Begin page -->
    <div id="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="left side-menu">
            <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
                <i class="ion-close"></i>
            </button>
            <div class="left-side-logo d-block d-lg-none">
                <div class="text-center">
                    <a class="logo" ><img src="../assets/ev-logo.png" width="100%">&nbsp;&nbsp;&nbsp;<?php echo $fet['shop_title']; ?></a>
                </div>
            </div>
            <div class="sidebar-inner  slimscrollleft">
                <div id="sidebar-menu">
                    <ul>
                        <li class="menu-title">Main</li>

                        <li>
                            <a href="dashboard.php" class="waves-effect">
                                <i class="dripicons-meter"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-battery-three-quarters"></i> <span> EV Battery</span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="battery_add.php">Battery Types List</a></li>
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa-solid fa-list-alt"></i> <span> EV Parts</span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="parts_add.php">EV Parts List </a></li>
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa-solid fa-motorcycle"></i> <span> Purchase Stock</span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="stock_purchase.php">Add Purchase</a></li>
                                <li><a href="stock_purchase_list.php">Purchase List</a></li>
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-users "></i> <span> Customers</span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="customer_add.php">Add Customer</a></li>
                                <li><a href="customers_list.php">Customers List</a></li>
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-shopping-cart "></i> <span> Sell</span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="sell_stock.php">Sell Stock</a></li>
                                <li><a href="sell_stock_list.php">Sell List</a></li>
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-check-circle"></i> <span> EV Claims</span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="claim_add.php">Add Claim</a></li>
                                <li><a href="claims_list.php">Pending Claim List</a></li>
                                <li><a href="claims_list_received.php">Received Claim List</a></li>
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-broadcast"></i>
                                <span> Expenses</span> <span class="menu-arrow float-right"><i
                                        class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">

                                <li><a href="expense_category_new.php">Expense Category</a></li>
                                <li><a href="expense_new.php">Add Expense</a></li>
                                <li><a href="expense_list.php">Expenses List</a></li>
                                
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-bank"></i> <span> Accounts </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="bank_account_add.php">Add Account</a></li>
                                <li><a href="bank_account_list.php">Account List</a></li>
                                <li><a href="bank_in_balance.php">Balance Management</a></li>
                                <li><a href="bank_management_list.php">Bank Balance List</a></li>
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-undo"></i> <span>Payment Recovery</span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="customer_recovery.php">Add Payment Details</a></li>
                                <li><a href="customer_recovery_list.php">Payment List</a></li>
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-book"></i> <span> Reports</span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="report_expenses.php">Expenses Report</a></li>
                                <li><a href="report_bikes.php">Bikes Report</a></li>
                                <li><a href="report_dues.php">Customer Dues Report</a></li>
                                <li><a href="report_sell.php">Sell Report</a></li>
                                <li><a href="report_stock.php">Stock Report</a></li>
                                <li><a href="report_profit_loss.php">Profit &amp; Loss Report</a></li>
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-synagogue"></i> <span> Company Details </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="shop_info.php">Company Info</a></li>
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-user"></i> <span> Admin</span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="profile.php">Profile</a></li>
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-database"></i> <span> Backup</span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="backup_page.php">DB Backup</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="clearfix"></div>
            </div> <!-- end sidebarinner -->
        </div>
        <!-- Left Sidebar End -->
        <!-- Start right Content here -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <!-- Top Bar Start -->
                <div class="topbar">
                    <div class="topbar-left d-none d-lg-block">
                        <div class="text-center pt-2">
                            <a class="text-white ">
                                <h5 class="animate__animated animate__bounce"><?php echo $fet['shop_title']; ?></h5>
                            </a>
                        </div>
                    </div>
                    <nav class="navbar-custom">
                        <ul class="list-inline float-right mb-0">
                            <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="../assets/images/user.png" alt="user" class="rounded-circle animate__animated animate__bounce" style="border:1px solid #54CC96; box-shadow: 1px 1px 3px 1px #ccc">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
                                    <a class="dropdown-item" href="signout.php"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-inline menu-left mb-0">
                            <li class="list-inline-item">
                                <button type="button" class="button-menu-mobile open-left waves-effect">
                                    <i class="ion-navicon"></i>
                                </button>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </nav>
                </div>