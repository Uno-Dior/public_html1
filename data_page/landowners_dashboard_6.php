<?php
session_start();

require_once '../mysql/conn.php';


if (empty($_SESSION["land"])) {
    header("Location: ../data_page/landowners_login.php");
    exit();
 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="..\data_image\favicon.png">
    <link rel="stylesheet" type="text/css" href="..\data_style\styles-dashboard1.css">   
    <!-- Vendor CSS Files -->
    <link href="../data_style/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../data_style/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../data_style/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../data_styleassets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../data_style/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../data_style/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../data_style/assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <!-- ======================================================= -->
    <title>Landowners - Monthly Report</title>
</head>
<body>
    <div class="dashboard_sidebar">
        <div>
            <a href="..\data_page\landowners_dashboard.php"><img src="..\data_image\LOGO.png" class="logo" alt="logo"></a>
        </div><hr>  
        <div class="dash1">
            <ul>
            <li style="margin: 10px 0 10px 0"><a href="..\data_page\landowners_dashboard.php">Dashboard</a></li>
            </ul>
        </div><hr>
        <div class="dash1">
            <h6>My Properties</h6>
            <ul>
                <li><a href="..\data_page\landowners_dashboard_2.php">Manage Inquiries</a></li>
                <!-- <li><a href="..\data_page\Landowners_Dashboard_3.php">Visit Schedules</a></li> -->
                <li><a href="..\data_page\landowners_dashboard_4.php">Manage Properties</a></li>
            </ul>
        </div><hr>
        <div class="dash1">
            <h6>My Tenants</h6>
            <ul>
                <li><a href="..\data_page\landowners_dashboard_5.php">Manage Tenants</a></li>
                <li class="active"><a href="..\data_page\landowners_dashboard_6.php"> Visit Schedules</a></li>
            </ul><hr>
        </div>
        <div class="dash1">
            <ul>
                <li><a href="..\logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="main">
        <div class="header-wrap">
            <div class="header-title">
                <ol>
                    <li><a href="../data_page/landowners_dashboard.php">Dashboard</a></li>
                    <li>Visit Schedule</li>
                </ol>
                <h2>Visit Schedule</h2>
            </div>
        </div>
        <div class="data_properties">
            <div class="properties">
                <div class="row">
                    <div class="col">
                      <div class="card shadow">
                        <div class="card-header border-0">
                          <!--<i class="fas fa-search" style="float:right"><input type="text" id="search" placeholder="Search items" style="font-family: Arial"></i>-->
                        </div>
                        <div class="table-responsive">
                          <table class="table align-items-center table-flush" id="example1">
                            <thead class="thead-light">
                              <tr>
                                <th scope="col">Inquirer Name</th>
                                <th scope="col">Contact Number</th>
                                <th scope="col">Date Schedule</th>
                                <th scope="col">Actions</th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div> 
    </div>
</body>
</html>