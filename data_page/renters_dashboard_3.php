<?php
// Include the database.php file
require_once '../mysql/conn.php';
session_start(); // Add this line

require('../data_page/navbar.php');

if (!isset($_SESSION["tenant"])) {
   header("Location: ../data_page/renters_login.php");
}

require_once '../mysql/conn.php';
           
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $adn = "DELETE FROM rental_options WHERE id = ?";
    $stmt = $mydb->getConnection()->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();

    if ($stmt) {
        $success = "Deleted" && header("refresh:1; url=renters_dashboard_3.php");
    } else {
        $err = "Try Again Later";
    }
}

$userid = $_SESSION['tenant']['userid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ResiHive - Profile</title>
    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="..\data_image\favicon.png">
    
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
    <!-- Main CSS Style -->
    <link rel="stylesheet" type="text/css" href="../data_style/style-renters.css">

    <!-- ======================================================= -->

</head>
    <body>

        <div class="bg_icons">
            <div class="hive_icon"></div>
            <div class="hexagon_icon"></div>
            <div class="sphere_icon"></div>
            <div class="comb_icon"></div>
        </div>

        <section class="mains">
            <div class="wrappers">
                <section class="section" style="display:flex; flex-direction: row;">
                    <div class="row">
                    <?php
                    $check_new = "SELECT * FROM tbl_renters_account where userid='$userid'";
                    $result = $conn->query($check_new);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                
                        <?php if (isset($_GET['success']) and $_GET['success'] == 'personaldata') { ?>

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-1"></i>
                            Profile successfully updated.
                            <a type="button" class="btn-close" href="../data_page/renters_dashboard_3.php" aria-label="Close"></a>
                        </div>
                        <?php }
                            ?>
                        <?php if (isset($_GET['success']) and $_GET['success'] == 'parentdata') { ?>

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-1"></i>
                            Profile successfully updated.
                            <a type="button" class="btn-close" href="../data_page/renters_dashboard_3.php" aria-label="Close"></a>
                        </div>
                        <?php }
                            ?>

                        <?php if (isset($_GET['success']) and $_GET['success'] == 'educationupdate') { ?>

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-1"></i>
                            Education successfully updated.
                            <a type="button" class="btn-close" href="../data_page/renters_dashboard_3.php" aria-label="Close"></a>
                        </div>
                        <?php }
                            ?>

                        <?php if (isset($_GET['success']) and $_GET['success'] == 'educationsave') { ?>

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-1"></i>
                            Education successfully inserted.
                            <a type="button" class="btn-close" href="../data_page/renters_dashboard_3.php" aria-label="Close"></a>
                        </div>
                        <?php }
                            ?>

                        <div class="col-lg-4">
                                        <div class="card">
                                            <div
                                                class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                                                <?php if ($row["profile_img"] == "") { ?>
                                                <img src="../data_style/assets/img/profile_icon.png" alt="Profile"
                                                    class="rounded-circle" width="120" height="120" id="profile-image">
                                                <form method="post" enctype="multipart/form-data" id="image-upload-form"
                                                action="../includes/insert-image.php">
                                                    <input class="form-control mt-2" type="file" id="formFile"
                                                        name="profile_image" accept="image/*" onchange="previewImage()">
                                                    <!-- Display submit button only when an image is selected -->
                                                    <input type="submit" value="Upload"
                                                        class="btn btn-info btn-md text-white text-center mt-2"
                                                        id="submit-button" style="display:none;" name="uploading">
                                                </form>
                                                <?php } else { ?>
                                                <img src="../data_style/assets/profile/<?php echo $row[
                                                            "profile_img"
                                                        ]; ?>" alt="Profile" class="rounded-circle" width="120"
                                                    height="120" id="profile-image">
                                                <form method="post" enctype="multipart/form-data" id="image-upload-form"
                                                action="../includes/insert-image.php">
                                                    <input class="form-control mt-2" type="file" id="formFile"
                                                        name="profile_image" accept="image/*" onchange="previewImage()">
                                                    <!-- Display submit button only when an image is selected -->
                                                    <input type="submit" value="Upload"
                                                        class="btn btn-info btn-md text-white text-center mt-2"
                                                        id="submit-button" style="display:none;" name="uploading">
                                                </form>
                                                <?php } ?>

                                                <h2>
                                                    <?php echo $row["f_name"] .
                                                            " " .
                                                            $row["s_name"]; ?>
                                                </h2>
                                                <h6>Tenants Profile</h6>
                                            </div>
                                        </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Renter Information</h5>


                                    <!-- Bordered Tabs -->
                                    <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="rental-tab" data-bs-toggle="tab"
                                                data-bs-target="#bordered-rental" type="button" role="tab" aria-controls="home"
                                                aria-selected="true" data-tab="rentals">Rentals Information</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                data-bs-target="#bordered-profile" type="button" role="tab" aria-controls="profile"
                                                aria-selected="true" data-tab="profile">Personal Information</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="parents-tab" data-bs-toggle="tab"
                                                data-bs-target="#bordered-parents" type="button" role="tab"
                                                aria-controls="profile" aria-selected="false" tabindex="-1"
                                                data-tab="parents">Parent's
                                                Details/Address</button>
                                        </li>
                                    </ul>

                                    <div class="tab-content pt-2" id="borderedTabContent">
                                        
                                        <div class="tab-pane fade active show" id="bordered-rental" role="tabpanel"
                                            aria-labelledby="rental-tab">
                                            
                                            <div class="row">
                                                <table class="table align-items-center table-flush" id="example1">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th scope="col">House Name</th>
                                                            <th scope="col">Rental Type</th>
                                                            <th scope="col">Price</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require_once '../mysql/conn.php';
                                                    
                                                        // Use JOIN to fetch data from house_rentals and rental_options tables
                                                        $ret = "SELECT hr.house_name, hr.house_type, hr.rent_amount, ro.status, ro.id, ro.house_id
                                                                FROM house_rentals hr
                                                                JOIN rental_options ro ON hr.house_id = ro.house_id
                                                                WHERE ro.renter_user_id = ?";
                                                    
                                                        $stmt = $mydb->getConnection()->prepare($ret);
                                                    
                                                        if ($stmt === false) {
                                                            die('Error in SQL query: ' . $mydb->getConnection()->error);
                                                        }
                                                    
                                                        $stmt->bind_param('s', $_SESSION['tenant']['userid']);
                                                        $stmt->execute();
                                                        $res = $stmt->get_result();
                                                    
                                                        while ($prod = $res->fetch_object()) {
                                                            ?>
                                                            <tr>
                                                                <td data-searchable="true"><?php echo $prod->house_name; ?></td>
                                                                <td data-searchable="true"><?php echo $prod->house_type; ?></td>
                                                                <td>₱ <?php echo $prod->rent_amount; ?></td>
                                                                <td><?php echo $prod->status; ?></td>
                                                                <td>
                                                                    <!-- Your delete and update buttons here -->
                                                                    <a href="../data_page/renters_dashboard_3.php?delete=<?php echo $prod->id; ?>">
                                                                        <button class="btn btn-sm btn-danger">
                                                                            <i class="fas fa-trash"></i>
                                                                            Delete
                                                                        </button>
                                                                    </a>
                                                                    <a href="../data_page/view-rental.php?id=<?php echo $prod->id; ?>">
                                                                        <button class="btn btn-sm btn-primary">
                                                                            <i class="fas fa-edit"></i>
                                                                            View
                                                                        </button>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        <div class="tab-pane fade" id="bordered-profile" role="tabpanel"
                                            aria-labelledby="profile-tab">
                                               <?php
                                                // print_r($_SESSION);
                                                
                                                if(isset($_SESSION['tenant']['userid'])) {
                                                    $userid = $_SESSION['tenant']['userid'];
                                                
                                                    // Fetch data from parent_details table
                                                    $ProfileDetails = "SELECT * FROM tbl_renters_account WHERE userid='$userid'";
                                                    $ProfileResult = $conn->query($ProfileDetails);
                                                
                                                    if ($ProfileResult->num_rows > 0) {
                                                        $Prodetails = mysqli_fetch_assoc($ProfileResult);
                                                        $f_name = $Prodetails['f_name'];
                                                        $m_name = $Prodetails['m_name'];  // fix variable name here
                                                        $s_name = $Prodetails['s_name'];
                                                        $birthdate = $Prodetails['birthdate'];
                                                        $birthplace = $Prodetails['birthplace'];
                                                        $citizenship = $Prodetails['citizenship'];
                                                        $email = $Prodetails['email'];
                                                        $num = $Prodetails['num'];
                                                        $civil_status = $Prodetails['civil_status'];
                                                        $gender = $Prodetails['gender'];
                                                        $education_status = $Prodetails['education_status'];
                                                        $social_media_link = $Prodetails['social_media_link'];
                                                    } else {
                                                        $f_name = ''; 
                                                        $m_name = ''; 
                                                        $s_name = ''; 
                                                        $birthdate = ''; 
                                                        $birthplace = ''; 
                                                        $citizenship = ''; 
                                                        $email = ''; 
                                                        $num = ''; 
                                                        $civil_status = ''; 
                                                        $gender = ''; 
                                                        $education_status = ''; 
                                                        $social_media_link = ''; 
                                                    }
                                                } else {
                                                    // Handle the case where 'userid' is not set in $_SESSION
                                                }
                                                
                                                ?>
                                            <form method="POST" action="../includes/save-applicant-info.php">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="inputName5" class="form-label ">Firstname</label>
                                                        <input type="text" class="form-control" id="inputName5"
                                                            value="<?php echo $f_name ?>" name="f_name">
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="inputName5" class="form-label">Middlename</label>
                                                        <input type="text" class="form-control" id="inputName5"
                                                            value="<?php echo $m_name ?>" name="m_name">
                                                    </div>

                                                    <div class=" col-md-4">
                                                        <label for="inputName5" class="form-label">Lastname</label>
                                                        <input type="text" class="form-control" id="inputName5"
                                                            value="<?php echo $s_name ?>" name="s_name">
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="inputName5" class="form-label">Date of Birth</label>
                                                        <input type="date" class="form-control" id="inputName5"
                                                            value="<?php echo $birthdate ?>" name="birthdate">
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="inputName5" class="form-label">Place of Birth</label>
                                                        <input type="text" class="form-control" id="inputName5"
                                                            value="<?php echo $birthplace ?>" name="birthplace">
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="inputName5" class="form-label">Citizenship</label>
                                                        <input type="text" class="form-control" id="inputName5"
                                                            value="<?php echo $citizenship ?>" name="citizenship">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="inputName5" class="form-label">Email Address</label>
                                                        <input type="text" class="form-control" id="inputName5"
                                                            value="<?php echo $email ?>"name="email">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="inputName5" class="form-label">Phone Number</label>
                                                        <input type="text" class="form-control" id="inputName5"
                                                            value="<?php echo $num ?>" name="num">
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="inputName5" class="form-label">Status</label>
                                                        <select class="form-control" name="civil_status">
                                                            <option value="" disabled selected hidden>Select an option</option>
                                                            <?php
                                                                $options = ["Single", "Married", "Widow/er", "Separated"];
                                                                foreach ($options as $option) {
                                                                    if ($civil_status === $option) {
                                                                        echo '<option value="' . $option . '" selected>' . $option . '</option>';
                                                                    } else {
                                                                        echo '<option value="' . $option . '">' . $option . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="inputName5" class="form-label">Gender/Sex</label>
                                                        <select class="form-control" name="gender">
                                                            <option value="" disabled selected hidden>Select an option</option>
                                                            <?php
                                                                $genders = ["Male", "Female"];
                                                                foreach ($genders as $gender) {
                                                                    if ($gender === $gender) {
                                                                        echo '<option value="' . $gender . '" selected>' . $gender . '</option>';
                                                                    } else {
                                                                        echo '<option value="' . $gender . '">' . $gender . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="inputName5" class="form-label">Education Status</label>
                                                        <select class="form-control" name="education_status">
                                                            <option value="" disabled selected hidden>Select an option</option>
                                                            <?php
                                                                $options = ["Student", "ALS Student", "out-of-school(OSY)"];
                                                                foreach ($options as $option) {
                                                                    if ($education_status === $option) {
                                                                        echo '<option value="' . $option . '" selected>' . $option . '</option>';
                                                                    } else {
                                                                        echo '<option value="' . $option . '">' . $option . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label for="inputName5" class="form-label">Social Media account
                                                            Link</label>
                                                        <input type="text" class="form-control" id="inputName5"
                                                            placeholder="FACEBOOK,TWITTER,INSTAGRAM,ETC" 
                                                            value="<?php echo $social_media_link ?>" name="social_media_link">
                                                    </div>
                                                </div>

                                                <div class="btn-save mt-2 text-center">
                                                    <button type="submit" name="savepersonal"
                                                        class="btn btn-info text-white btn-sm">Save
                                                        Details</button>
                                                </div>
                                            </form>

                                        </div>

                                        <div class="tab-pane fade" id="bordered-parents" role="tabpanel"
                                            aria-labelledby="parents-tab">

                                            <?php
                                                // print_r($_SESSION);
                                                
                                                if(isset($_SESSION['tenant']['userid'])) {
                                                    $userid = $_SESSION['tenant']['userid'];
                                                
                                                    // Fetch data from parent_details table
                                                    $ParentsDetails = "SELECT * FROM parent_details WHERE userid='$userid'";
                                                    $ParentResult = $conn->query($ParentsDetails);
                                                
                                                    if ($ParentResult->num_rows > 0) {
                                                        $Pdetails = mysqli_fetch_assoc($ParentResult);
                                                        $father_name = $Pdetails['father_name'];
                                                        $father_contact = $Pdetails['father_contact'];
                                                        $father_occupation = $Pdetails['father_occupation'];
                                                        $mother_name = $Pdetails['mother_name'];
                                                        $mother_contact = $Pdetails['mother_contact'];
                                                        $mother_occupation = $Pdetails['mother_occupation'];
                                                    } else {
                                                        $parent_status = '';
                                                        $father_name = '';
                                                        $father_contact = '';
                                                        $father_occupation = '';
                                                        $mother_name = '';
                                                        $mother_contact = '';
                                                        $mother_occupation = '';
                                                    }
                                                
                                                    // Fetch data from tenants_address table
                                                    $select_address = "SELECT * FROM tenants_address WHERE userid='$userid'";
                                                    $address_res = $conn->query($select_address);
                                                
                                                    if ($address_res->num_rows > 0) {
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
                                                } else {
                                                    // Handle the case where 'userid' is not set in $_SESSION
                                                }
                                                ?>
                                            <form method="POST" action="../includes/save-applicant-info.php">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="inputName5" class="form-label mt-2"><b>
                                                                Address</b></label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="inputName5" class="form-label">Street/House Number</label>
                                                        <input type="text" class="form-control" id="inputName5" placeholder=""
                                                            value="<?php echo $street ?>" name="street">
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="inputName5" class="form-label">Barangay</label>
                                                        <input type="text" class="form-control" id="inputName5" placeholder=""
                                                            value="<?php echo $barangay ?>" name="barangay">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="inputName5" class="form-label">Municipality</label>
                                                        <input type="text" class="form-control" id="inputName5" placeholder=""
                                                            value="<?php echo $municipality ?>" name="municipality">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="inputName5" class="form-label">Zip Code</label>
                                                        <input type="text" class="form-control" id="inputName5" placeholder=""
                                                            value="<?php echo $zipcode ?>" name="zipcode">
                                                    </div>

                                                    <div class="col-md-4 col-12">
                                                        <label for="inputName5" class="form-label">Father's Name</label>
                                                        <input type="text" class="form-control" id="inputName5"
                                                            value="<?php echo $father_name ?>" name="father_name">
                                                    </div>

                                                    <div class="col-md-4 col-12">
                                                        <label for="inputName5" class="form-label">Father's Contact
                                                            Number</label>
                                                        <input type="text" class="form-control" id="inputName5"
                                                            value="<?php echo $father_contact ?>" name="father_contact">
                                                    </div>

                                                    <div class="col-md-4 col-12">
                                                        <label for="inputName5" class="form-label">Father's Occupation</label>
                                                        <input type="text" class="form-control" id="inputName5"
                                                            value="<?php echo $father_occupation ?>" name="father_occupation">
                                                    </div>

                                                    <div class="col-md-4 col-12">
                                                        <label for="inputName5" class="form-label">Mother's Name</label>
                                                        <input type="text" class="form-control" id="inputName5"
                                                            value="<?php echo $mother_name ?>" name="mother_name">
                                                    </div>

                                                    <div class="col-md-4 col-12">
                                                        <label for="inputName5" class="form-label">Mother's Contact
                                                            Number</label>
                                                        <input type="text" class="form-control" id="inputName5"
                                                            value="<?php echo $mother_contact ?>" name="mother_contact">
                                                    </div>

                                                    <div class="col-md-4 col-12">
                                                        <label for="inputName5" class="form-label">Mother's Occupation</label>
                                                        <input type="text" class="form-control" id="inputName5"
                                                            value="<?php echo $mother_occupation ?>" name="mother_occupation">
                                                    </div>
                                                    <div class="btn-save mt-2 text-center">
                                                        <button type="submit" name="saveparent"
                                                            class="btn btn-info text-white btn-sm">Save
                                                            Details</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div><!-- End Bordered Tabs -->

                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </section><!-- End Section -->


        <!-- Start Footer -->
        <!--<footer id="footer" class="footer">-->
        <!--<div class="copyright">-->
        <!--    by &copy;<strong><span>ResiHive 2023</span></strong>-->
        <!--</div>-->
        <!--<div class="credits"></div>-->
        <!--</footer> -->
        <!-- End Footer-->

    <script src="..\jscripts\dropdownfeat.js"></script>

        <!-- Vendor JS Files -->
    <script src="../data_style/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../data_style/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../data_style/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../data_style/assets/vendor/echarts/echarts.min.js"></script>
    <script src="../data_style/assets/vendor/quill/quill.min.js"></script>
    <script src="../data_style/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../data_style/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../data_style/assets/vendor/php-email-form/validate.js"></script>
    <!-- Template Main JS File -->
    <script src="../data_style/assets/js/main.js"></script>

    <script>
// Function to set the active tab based on a cookie or localStorage
function setActiveTab() {
    const activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        const tabButton = document.querySelector(`#${activeTab}-tab`);
        if (tabButton) {
            tabButton.classList.add('active');
            const tabContent = document.querySelector(`#${activeTab}`);
            if (tabContent) {
                tabContent.classList.add('active', 'show');
            }
        }
    }
}

// Add an event listener to each tab button to remember the active tab
const tabButtons = document.querySelectorAll('.nav-link');
tabButtons.forEach(button => {
    button.addEventListener('click', () => {
        const tabId = button.getAttribute('id');
        localStorage.setItem('activeTab', tabId);
    });
});

// Call the setActiveTab function when the page loads
window.addEventListener('load', setActiveTab);
</script>

<script>
function previewImage() {
    var input = document.getElementById('formFile');
    var image = document.getElementById('profile-image');
    var submitButton = document.getElementById('submit-button');

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            image.src = e.target.result;
            // Show the submit button when an image is selected
            submitButton.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>

    </body>
</html>