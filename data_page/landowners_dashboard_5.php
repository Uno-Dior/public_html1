<?php
session_start();

if (!isset($_SESSION["land"])) {
   header("Location: ../data_page/landowners_login.php");
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
    <title>Landowners - Manage Tenants</title>
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
                <li class="active"><a href="..\data_page\landowners_dashboard_5.php">Manage Tenants</a></li>
                <li><a href="..\data_page\landowners_dashboard_6.php">Visit Schedules</a></li>
            </ul><hr>
        </div>
        <div class="dash1">
            <ul>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="main">
        <div class="header-wrap">
            <div class="header-title">
                <ol>
                    <li><a href="../data_page/landowners_dashboard.php">Dashboard</a></li>
                    <li>Manage Tenants</li>
                </ol>
                <h2>Manage Tenants</h2>
            </div>
        </div>
        <div class="data_properties">
            <section class="inquiries">
            <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Name of Property</th>
                                        <th scope="col">Name of Tenant</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Tenant Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                        require_once '../database/database.php';
                                        $select_spes = "SELECT *, rental_options.status as appstatus, house_rentals.house_name as house_name
                                            FROM tbl_renters_account
                                            JOIN tenants_address ON tbl_renters_account.userid = tenants_address.userid
                                            JOIN rental_options ON tbl_renters_account.userid = rental_options.renter_user_id
                                            JOIN house_rentals ON rental_options.house_id = house_rentals.house_id
                                            WHERE rental_options.status ='Approved'
                                                AND rental_options.owner_user_id = {$_SESSION['land']['userid']}";
                                        $result = $conn->query($select_spes);
                                        if ($result !== false && $result->num_rows > 0) {

                                            while ($row = mysqli_fetch_assoc($result)) {

                                                ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $row['house_name'] ?>
                                        </th>                                        
                                        <th scope="row">
                                            <?php echo $row['f_name'] ?>
                                            <?php echo $row['s_name'] ?>
                                        </th>
                                        <td>
                                            <?php echo $row['st_house_num'] ?>
                                            <?php echo $row['barangay'] ?>,
                                            <?php echo $row['municipality'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row['email'] ?>

                                        </td>
                                        <td>
                                            <?php echo $row['appstatus'] ?>

                                        </td>
                                        <td> <a href="view-user.php?userid=<?php echo $row['userid'] ?>"
                                                class="btn btn-sm btn-info text-white"><i class=" bi bi-eye-fill"></i>
                                                <a href="landowners_dashboard_3.php?userid=<?php echo $row['userid'] ?>"
                                                class="btn btn-sm btn-info text-white"><i class=" bi bi-chat-dots-fill"></i>
                                            </a> </td>
                                    </tr>

                                    <?php }
                                        } ?>
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
            </section>
        </div> 
    </div>
</body>
</html>