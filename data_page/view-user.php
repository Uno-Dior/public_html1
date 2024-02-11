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
    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="..\data_image\favicon.png">
    <!-- Main CSS Style -->
    <link rel="stylesheet" type="text/css" href="..\data_style\styles-dashboard.css">
    <!-- Vendor CSS Files -->
    <link href="../data_style/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../data_style/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../data_style/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../data_style/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../data_style/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../data_style/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../data_style/assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="../data_style/assets/css/style.css" rel="stylesheet">
    <!-- ======================================================= -->
    <title>Landowners - Manage Inquiries</title>
</head>
<body>
    <div class="dashboard_sidebar">
        <div>
            <a href="..\data_page\ResiHive.php"><img src="..\data_image\LOGO.png" class="logo" alt="logo"></a>
        </div><hr>
        <div class="dash1">
            <ul>
                <li><a href="..\data_page\landowners_dashboard.php">Dashboard</a></li>
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
                <li style="margin-bottom: 20px"><a href="..\data_page\landowners_dashboard_6.php">Monthly Reports</a></li>
            </ul><hr>
        </div>
        <div class="dash1">
            <ul>
                <li><a href="../">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="main">
        <div class="header-wrap">
            <div class="header-title">
                <?php
                    require_once '../database/database.php';
                    $renter_user_id = $_GET['userid'];
                    $select_user = "SELECT * FROM rental_options WHERE renter_user_id='$renter_user_id'";
                    $ures = $conn->query($select_user);
                    $uRow = mysqli_fetch_assoc($ures);
                    if($uRow['status']!='Approved')
                    {
                        echo'<span>My Properties</span>
                        <h2 style="margin-top: 5px">Manage Inquirer</h2>';
                    }/*elseif($uRow['status']=='Approved')
                    {
                        $select_access = "SELECT * FROM examinee_access WHERE userid='$userid'";
                        $res = $conn->query($select_access);
                        if($res->num_rows > 0)
                    {
                        
                        }*/
                        else
                    {
                            echo'<span>My Tenants</span>
                            <h2 style="margin-top: 5px">Manage Tenant</h2>';
                    }
                    
                ?>
            </div>
        <!--<div class="user-info">
                <div class="search_box">
                    <form action="/action_page.php">
                        <input type="text" placeholder="Search.." name="search">
                    </form>
                </div>
            </div>-->
        </div>
        <div class="dataInquiries">
            <section class="inquiries">
                <section class="section profile">
                <?php
                if(isset($_SESSION['access_sent']) && $_SESSION['access_sent'] =='access sent')
                {
                    echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Examination Acess successfully sent
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
                unset($_SESSION['access_sent']);
                ?>
                <?php
                $userid = $_GET['userid'];
                $select_application ="SELECT * FROM tbl_renters_account WHERE userid='$userid'";
                $result = $conn->query($select_application);
                $udetails = mysqli_fetch_assoc($result);
                ?>
                <div class="row">
                    <div class="col-xl-3">

                        <div class="card">
                            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                                <img src="../data_style/assets/profile/<?php echo $udetails['profile_img'] ?>" alt="Profile"
                                    class="rounded-circle" width="120" height="120">
                                <h2><?php echo $udetails['f_name'].' '.$udetails['s_name'] ?></h2>
                                <h3>Inquirer</h3>
                                <div class="social-links mt-2">
                                    <a href="<?php echo $udetails['social_media_link'] ?>" class="text-sm"
                                        style="font-size:13px;"><i class="bi bi-link"></i> Facebook Link</a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Inquirer Information</h5>


                                <!-- Bordered Tabs -->
                                <?php
                                    $renter_user_id = $_GET['userid'];
                                    $select_user = "SELECT * FROM rental_options WHERE renter_user_id='$renter_user_id'";
                                    $ures = $conn->query($select_user);
                                    $uRow = mysqli_fetch_assoc($ures);
                                ?>
                                    
                                    <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
                                        <?php if ($uRow['status'] == 'Approved') : ?>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="education-tab" data-bs-toggle="tab" data-bs-target="#bordered-education"
                                                    type="button" role="tab" aria-controls="contact" aria-selected="false" tabindex="-1" data-tab="education">
                                                    Rental
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                    
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-profile"
                                                type="button" role="tab" aria-controls="home" aria-selected="true" data-tab="profile">Inquirer Details
                                            </button>
                                        </li>
                                    
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="parents-tab" data-bs-toggle="tab" data-bs-target="#bordered-parents"
                                                type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1" data-tab="parents">
                                                Parent's Details/Address
                                            </button>
                                        </li>
                                    </ul>

                                    <div class="tab-pane fade active show" id="bordered-education" role="tabpanel"
                                        aria-labelledby="education-tab">
                                        <?php
                                            $userid = $_GET['userid'];
                                            $account_details = "SELECT * FROM tbl_renters_account where userid='$userid'";
                                            $acc_res = $conn->query($account_details);
                                            $accdetails = mysqli_fetch_assoc($acc_res);
                                            ?>
                                        <form method="POST" action="view-user.php">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label ">Firstname</label>
                                                    <h5 class="user-value"><?php echo $accdetails['f_name']?></h5>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label">Middlename</label>
                                                    <h5 class="user-value"><?php echo $accdetails['m_name']?></h5>
                                                </div>

                                                <div class=" col-md-4">
                                                    <label for="inputName5" class="form-label">Lastname</label>
                                                    <h5 class="user-value"><?php echo $accdetails['s_name']?></h5>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label">Date of Birth</label>
                                                    <h5 class="user-value"><?php echo $accdetails['birthdate']?></h5>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label">Place of Birth</label>
                                                    <h5 class="user-value"><?php echo $accdetails['birthplace']?></h5>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label">Citizenship</label>
                                                    <h5 class="user-value"><?php echo $accdetails['citizenship']?></h5>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="inputName5" class="form-label">Email Address</label>
                                                    <h5 class="user-value"><?php echo $accdetails['email']?></h5>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="inputName5" class="form-label">Phone Number</label>
                                                    <h5 class="user-value"><?php echo $accdetails['num']?></h5>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label">Status</label>
                                                    <h5 class="user-value"><?php echo $accdetails['civil_status']?></h5>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label">Gender/Sex</label>
                                                    <h5 class="user-value"><?php echo $accdetails['gender']?></h5>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label">Education Status</label>
                                                    <h5 class="user-value"><?php echo $accdetails['education_status']?></h5>
                                                </div>

                                                <div class="col-md-12">
                                                    <label for="inputName5" class="form-label">Facebook account Link</label>
                                                    <h5 class="user-value"><?php echo $accdetails['social_media_link']?></h5>
                                                </div>
                                            </div>
                                        </form>

                                    </div>

                                    <div class="tab-pane fade" id="bordered-profile" role="tabpanel"
                                        aria-labelledby="profile-tab">
                                        <?php
                                            $userid = $_GET['userid'];
                                            $account_details = "SELECT * FROM tbl_renters_account where userid='$userid'";
                                            $acc_res = $conn->query($account_details);
                                            $accdetails = mysqli_fetch_assoc($acc_res);
                                            ?>
                                        <form method="POST" action="view-user.php">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label ">Firstname</label>
                                                    <h5 class="user-value"><?php echo $accdetails['f_name']?></h5>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label">Middlename</label>
                                                    <h5 class="user-value"><?php echo $accdetails['m_name']?></h5>
                                                </div>

                                                <div class=" col-md-4">
                                                    <label for="inputName5" class="form-label">Lastname</label>
                                                    <h5 class="user-value"><?php echo $accdetails['s_name']?></h5>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label">Date of Birth</label>
                                                    <h5 class="user-value"><?php echo $accdetails['birthdate']?></h5>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label">Place of Birth</label>
                                                    <h5 class="user-value"><?php echo $accdetails['birthplace']?></h5>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label">Citizenship</label>
                                                    <h5 class="user-value"><?php echo $accdetails['citizenship']?></h5>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="inputName5" class="form-label">Email Address</label>
                                                    <h5 class="user-value"><?php echo $accdetails['email']?></h5>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="inputName5" class="form-label">Phone Number</label>
                                                    <h5 class="user-value"><?php echo $accdetails['num']?></h5>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label">Status</label>
                                                    <h5 class="user-value"><?php echo $accdetails['civil_status']?></h5>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label">Gender/Sex</label>
                                                    <h5 class="user-value"><?php echo $accdetails['gender']?></h5>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label">Education Status</label>
                                                    <h5 class="user-value"><?php echo $accdetails['education_status']?></h5>
                                                </div>

                                                <div class="col-md-12">
                                                    <label for="inputName5" class="form-label">Facebook account Link</label>
                                                    <h5 class="user-value"><?php echo $accdetails['social_media_link']?></h5>
                                                </div>
                                            </div>
                                        </form>

                                    </div>

                                    <div class="tab-pane fade" id="bordered-parents" role="tabpanel"
                                        aria-labelledby="parents-tab">

                                        <?php
                                            $userid = $_GET['userid'];
                                            $ParentsDetails = "SELECT * FROM parent_details where userid='$userid'";
                                            $ParentResult = $conn->query($ParentsDetails);
                                            if ($ParentResult !== false && $ParentResult->num_rows > 0) {
                                                $Pdetails = mysqli_fetch_assoc($ParentResult);
                                                
                                                $father_name = $Pdetails['father_name'];
                                                $father_contact = $Pdetails['father_contact'];
                                                $father_occupation = $Pdetails['father_occupation'];
                                                $mother_name = $Pdetails['mother_name'];
                                                $mother_contact = $Pdetails['mother_contact'];
                                                $mother_occupation = $Pdetails['mother_occupation'];
                                            } else {

                                                $father_name = '';
                                                $father_contact = '';
                                                $father_occupation = '';
                                                $mother_name = '';
                                                $mother_contact = '';
                                                $mother_occupation = '';
                                            }
                                            $select_address = "SELECT * FROM tenants_address where userid='$userid'";
                                            $address_res = $conn->query($select_address);
                                            if ($address_res !== false && $address_res->num_rows > 0) {
                                                $address = mysqli_fetch_assoc($address_res);
                                                $street = $address["st_house_num"];
                                                $barangay = $address["barangay"];
                                                $municipality = $address['municipality'];
                                                $zipcode = $address['postal_code'];
                                            } else {
                                                $street = '';
                                                $barangay = '';
                                                $municipality = '';
                                                $zipcode = '';
                                            }
                                            ?>
                                        <form method="POST" action="view-user.php">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="inputName5" class="form-label mt-2"><b>
                                                            Address</b></label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="inputName5" class="form-label">Street/House Number</label>
                                                    <h5 class="user-value"><?php echo $street ?></h5>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="inputName5" class="form-label">Barangay</label>
                                                    <h5 class="user-value"><?php echo $barangay ?></h5>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="inputName5" class="form-label">Municipality</label>
                                                    <h5 class="user-value"><?php echo $municipality ?></h5>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="inputName5" class="form-label">Zip Code</label>
                                                    <h5 class="user-value"><?php echo $zipcode ?></h5>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <label for="inputName5" class="form-label">Father's Name</label>
                                                    <h5 class="user-value"><?php echo $father_name ?></h5>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <label for="inputName5" class="form-label">Father's Contact Number</label>
                                                    <h5 class="user-value"><?php echo $father_contact ?></h5>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <label for="inputName5" class="form-label">Father's Occupation</label>
                                                    <h5 class="user-value"><?php echo $father_occupation ?></h5>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <label for="inputName5" class="form-label">Mother's Name</label>
                                                    <h5 class="user-value"><?php echo $mother_name ?></h5>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <label for="inputName5" class="form-label">Mother's Contact Number</label>
                                                    <h5 class="user-value"><?php echo $mother_contact ?></h5>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <label for="inputName5" class="form-label">Mother's Occupation</label>
                                                    <h5 class="user-value"><?php echo $mother_occupation ?></h5>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div><!-- End Bordered Tabs -->

                            </div>
                        </div>
                    </div>


                        <div class="col-lg-12">
                        <?php 
                        if(isset($_SESSION['incomplete']) && $_SESSION['incomplete']=='Must approve all')
                        {
                            echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-octagon me-1"></i>
                            Please check the files and you must approve all the files before approving the application
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        }
                        unset($_SESSION['incomplete']);
                        ?>

                        <div class="card">
                            <div class="card-body pt-3">

                                <div class="tab-content pt-2">

                                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                        <h5 class="card-title">Inquirer's File</h5>
                                        <table class="table datatable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">File Type</th>
                                                    <th scope="col">File Name</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $userid = $_GET['userid'];
                                                $select_spes = "SELECT * FROM tenants_file where userid='$userid'";
                                                $result = $conn->query($select_spes);
                                                if ($result->num_rows > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                <tr>
                                                    <th scope="row">
                                                        <?php echo $row['file_type'] ?>

                                                    </th>
                                                    <td>
                                                        <?php echo $row['file_name'] ?>
                                                    </td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-info text-white"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#viewfile<?php echo $row['id'] ?>"><i
                                                                class=" bi bi-eye-fill"></i>
                                                        </a>
                                                    </td>
                                                </tr>

                                                <div class="modal fade" id="viewfile<?php echo $row['id'] ?>" tabindex="-1">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Inquirer File</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <iframe
                                                                    src="../data_style/assets/files/<?php echo $row['file_name'] ?>"
                                                                    width="100%" height="500px"></iframe>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- End Basic Modal-->

                                                <!-- Approval modal -->
                                                <div class="modal fade" id="approval<?php echo $row['id'] ?>" tabindex="-1">
                                                    <div class="modal-dialog modal-md">
                                                        <div class="modal-content">
                                                            <form method="POST" action="../includes/update-file.php">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><?php echo $row['file_name'] ?>
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <input type="text"
                                                                            value="<?php echo $row['file_name'] ?>"
                                                                            name="filename" hidden>
                                                                        <input type="text" name="userid"
                                                                            value="<?php echo $_GET['userid'] ?>" hidden>
                                                                        <div class="col-12">
                                                                            <label for="approval" class="form-label">File
                                                                                Status</label>
                                                                            <select class="form-control approval-status"
                                                                                id="approvalStatus" name="filestatus"
                                                                                data-id="<?php echo $row['file_name'] ?>">
                                                                                <option>Approved</option>
                                                                                <option>Reject</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-12 reject-reason mt-2">
                                                                            <label for="reason" class="form-label">Reject
                                                                                Reason(if Reject)</label>
                                                                            <textarea name="reason" class="form-control"
                                                                                id="reason" rows="4"
                                                                                data-id="<?php echo $row['file_name']; ?>"></textarea>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" name="updatefile"
                                                                        class="btn btn-primary">Save
                                                                        changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div><!-- End Basic Modal-->
                                                <?php }
                                                
                                            } ?>
                                            </tbody>
                                        </table>
                                        <?php
                                        $userid = $_GET['userid'];
                                        $renter_user_id = $_GET['userid'];
                                        $select_user = "SELECT * FROM rental_options WHERE renter_user_id='$renter_user_id'";
                                        $ures = $conn->query($select_user);
                                        $uRow = mysqli_fetch_assoc($ures);
                                        if ($uRow['status'] != 'Approved') {
                                            echo '<a href="#" class="btn btn-info text-white float-end" data-bs-toggle="modal"
                                                    data-bs-target="#notify">Approve Inquirer</a>';
                                        } else {
                                            echo '<a href="#" class="btn btn-discard text-white float-end" data-bs-toggle="modal"
                                                    data-bs-target="#discard">Remove Tenant</a>';
                                        }
                                        ?>
                                        
                                        <!-- Approval modal -->
                                            <div class="modal fade" id="notify" tabindex="-1">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <form method="POST" action="../includes/update-application.php">
                                                            <div class="modal-header bg-primary">
                                                                <h5 class="modal-title text-white">
                                                                    Approve Inquirer
                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <input type="text" name="userid" value="<?php echo $renter_user_id; ?>" hidden>
                                                                    <div class="col-12">
                                                                        <label for="approval" class="form-label">Application Status</label>
                                                                        <select class="form-control approval-status" id="approvalStatus" name="application_status">
                                                                            <option value="Approved">Approved</option>
                                                                            <option value="Rejected">Rejected</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" name="update_app" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div><!-- End Basic Modal-->

                                            <!-- Discard modal -->
                                            <div class="modal fade" id="discard" tabindex="-1">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <form method="POST" action="../includes/discard-application.php">
                                                            <div class="modal-header bg-warning">
                                                                <h5 class="modal-title text-white">
                                                                    Discard Tenant
                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <input type="text" name="userid" value="<?php echo $renter_user_id; ?>" hidden>
                                                                    <div class="col-12">
                                                                        <label for="discard" class="form-label">Tenant Status</label>
                                                                        <select class="form-control discard-status" id="discardStatus" name="tenant_status">
                                                                            <option value="Discarded">Remove Tenant</option>
                                                                            <!-- Add other discard options if needed -->
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" name="discard_app" class="btn btn-warning">Remove</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div><!-- End Discard Modal -->
                                    </div>



                                </div><!-- End Bordered Tabs -->

                            </div>
                        </div>

                    </div>
                </div>
            </section>
            </section>
        </div> 
    </div>
    <!-- Vendor JS Files -->
    <script src="../data_style/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../data_style/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../data_style/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../data_style/assets/vendor/echarts/echarts.min.js"></script>
    <script src="../data_style/assets/vendor/quill/quill.min.js"></script>
    <script src="../data_style/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <!--<script src="../data_style/assets/vendor/tinymce/tinymce.min.js"></script>-->
    <script src="../data_style/assets/vendor/php-email-form/validate.js"></script>
    <!-- Template Main JS File -->
    <script src="../data_style/assets/js/main.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tabs = document.querySelectorAll('.nav-link');
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    const tabTarget = this.getAttribute('data-bs-target');
                    tabPanes.forEach(pane => {
                        if (pane.id === tabTarget.substring(1)) {
                            pane.style.display = 'flex';
                        } else {
                            pane.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>