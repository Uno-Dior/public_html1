<?php
session_start();

if (!isset($_SESSION["land"])) {
   header("Location: ..\data_page\landowners_login.php");
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
    <title>Landowners - Dashboard</title>
</head>
<body>
    <div class="dashboard_sidebar">
        <div>
            <a href="..\data_page\landowners_dashboard.php"><img src="..\data_image\LOGO.png" class="logo" alt="logo"></a>
        </div><hr>  
        <div class="dash1">
            <ul>
                <li style="margin: 10px 0 10px 0" class="active"><a href="..\data_page\landowners_dashboard.php">Dashboard</a></li>
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
                <span>Primary</span>
                <h2 style="margin-top: 5px">Dashboard</h2>
            </div>
        <!--<div class="user-info">
                <div class="search_box">
                    <form action="/action_page.php">
                        <input type="text" placeholder="Search.." name="search">
                    </form>
                </div>
            </div>-->
        </div>
        <div class="data_stat">
            <div class="monthly_payments">
            <div class="col-xxl-4 col-md-6" style="width: 100%; height: 100%;">
                    <div class="card info-card sales-card">

                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>

                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Visitation <span class="text-success">| Visits</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-folder"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>
                                        <?php
                                        require_once '../database/database.php';
                                            $select_application = "SELECT * FROM rent_price where rent_remark='Paid'";
                                            $result = $conn->query($select_application);
                                            echo $result->num_rows;
                                            ?>

                                    </h6>
                                    <a href="..\data_page\landowners_dashboard_6.php" class="text-muted small pt-2 ps-1">Visits</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="num_inquiries">
                <div class="col-xxl-4 col-md-6" style="width: 100%; height: 100%;">
                    <div class="card info-card sales-card">

                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>

                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Application <span>| Pending</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-folder"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>
                                        <?php
                                            // print_r($_SESSION);

                                            $userID = $_SESSION['land']['userid'];
                                            $select_application = "SELECT * FROM rental_options WHERE status='Pending' AND owner_user_id={$userID}";
                                            $result = $conn->query($select_application);
                                            echo $result->num_rows;
                                            ?>

                                    </h6>
                                    <a href="..\data_page\landowners_dashboard_2.php" class="text-muted small pt-2 ps-1">View
                                        Pending</a>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="num_visits">
            <div class="col-xxl-4 col-md-6" style="width: 100%; height: 100%;">
                    <div class="card info-card sales-card">

                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>

                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Application <span class="text-success">| Approved</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-folder"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>
                                        <?php
                                        if (isset($_SESSION['land']['userid'])) {
                                            $userID = $_SESSION['land']['userid'];
                                            $select_application = "SELECT * FROM rental_options where status='Approved' AND owner_user_id={$_SESSION['land']['userid']}";
                                            $result = $conn->query($select_application);
                                            echo $result->num_rows;
                                        }
                                            ?>
                                    </h6>
                                    <a href="..\data_page\landowners_dashboard_5.php" class="text-muted small pt-2 ps-1">View
                                        Tenants</a>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="stat_container">
            <div class="data_diagram_inquiries">
            <section class="inquiries" style="padding: 0px;">
            <div class="row">
                <div class="col-lg-13">
                    <div class="card">
                        <div class="card-body">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Name of Inquirer</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                               <tbody>
                                    <?php
                                        $tenants = "SELECT *, rental_options.status as appstatus, tbl_renters_account.userid as cid
                                            FROM tbl_renters_account
                                            JOIN rental_options ON tbl_renters_account.userid = rental_options.renter_user_id
                                            WHERE (rental_options.status ='Re upload Some Files' OR rental_options.status ='Pending')
                                                AND rental_options.owner_user_id = {$_SESSION['land']['userid']}";
                                        $result = $conn->query($tenants);
                                        if ($result !== false && $result->num_rows > 0) {

                                            while ($row = mysqli_fetch_assoc($result)) {

                                                ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $row['f_name'] ?>
                                            <?php echo $row['s_name'] ?>
                                        </th>
                                        <td>
                                            <?php echo $row['appstatus'] ?>

                                        </td>
                                        <td> 
                                            <a href="view-user.php?userid=<?php echo $row['cid'] ?>"
                                                class="btn btn-sm btn-info text-white"><i class="bi bi-eye-fill"></i>
                                            </a>
                                        </td>
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
            </div>
            <div class="data_summary">
                <div class="card">
                    <div class="card-body pb-0">
                                    <h5 class="card-title">Summary Report <span>| Visits/Approved/Pending</span></h5>

                                    <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

                                    <script>
                                   <?php
                                            //Visits
                                            $rent = "SELECT * FROM rent_price where rent_remark='Paid'";
                                            $res_failed = $conn->query($rent);
                                            $paid = $res_failed->num_rows;
                                            
                                            //Pending
                                            $pending = "SELECT * FROM rental_options where status='Pending' AND owner_user_id={$_SESSION['land']['userid']}";
                                            $res_passed = $conn->query($pending);
                                            $pend = $res_passed->num_rows;

                                            //approved
                                            $approve = "SELECT * FROM rental_options where status='Approved' AND owner_user_id={$_SESSION['land']['userid']}";
                                            $res_not = $conn->query($approve);
                                            $app = $res_not->num_rows;
                                            ?>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        echarts.init(document.querySelector("#trafficChart")).setOption({
                                            tooltip: {
                                                trigger: 'item'
                                            },
                                            legend: {
                                                top: '5%',
                                                left: 'center'
                                            },
                                            series: [{
                                                name: 'Access From',
                                                type: 'pie',
                                                radius: ['40%', '70%'],
                                                avoidLabelOverlap: false,
                                                label: {
                                                    show: false,
                                                    position: 'center'
                                                },
                                                emphasis: {
                                                    label: {
                                                        show: true,
                                                        fontSize: '18',
                                                        fontWeight: 'bold'
                                                    }
                                                },
                                                labelLine: { 
                                                    show: false
                                                },
                                                data: [{
                                                        value: <?php echo $paid ?>,
                                                        name: 'Visits',
                                                        itemStyle: {
                                                            color: '#E34234' // Change the color here
                                                        }
                                                    },
                                                    {
                                                        value: <?php echo $pend ?>,
                                                        name: 'Pending',
                                                        itemStyle: {
                                                            color: '#0d98ba' // Change the color here
                                                        }
                                                    },
                                                    {
                                                        value: <?php echo $app ?>,
                                                        name: 'Approved',
                                                        itemStyle: {
                                                            color: '#ffcc5c' // Change the color here
                                                        }
                                                    }
                                                ]
                                            }]
                                        });
                                    });
                                    </script>

                                </div>
                </div><!-- End Website Traffic -->
            </div>
        </div>  
    </div>
    
        <!-- Vendor JS Files -->
    <script src="../data_style/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../data_style/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../data_style/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../data_style/assets/vendor/echarts/echarts.min.js"></script>
    <script src="../data_style/assets/vendor/quill/quill.min.js"></script>
    <script src="../data_style/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../data_style/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../data_style/assets/vendor/php-email-form/validate.js"></script>
    
</body>
</html>