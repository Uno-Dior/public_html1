<?php
// print_r($_SESSION);
require('../includes/account-details.php');
?>
<div class="navbar-container">
    <link rel="stylesheet" type="text/css" href="../data_style/styles-navbar.css">
	<script src="https://kit.fontawesome.com/4d86b94a8a.js" crossorigin="anonymous"></script>

    <div class="navigation_bar"></div>
    <div class="navbar_container" id="navbar">
        <div class="sea_container">
            <div>
                <a href="../data_page/renters_dashboard_1.php"><img src="../data_image/LOGO.png" class="logo" alt="logo"></a>
            </div>
            <div class="nav_container">
                <ul class="navbar_links">
                    <li><a href="../data_page/renters_dashboard_1.php"><i class="fas fa-home fa-2x"> HOME</i></a></li>
                    <li><a href="../data_page/renters_dashboard_2.php"><i class="fas fa-comment-alt fa-2x"> CHAT</i></a></li>
                    <!-- <li><a href="../data_page/renters_dashboard_3.php"><img src="../data_image/Personal Icon.png" class="icon" alt="personal_icon"></a></li> -->
                </ul>
            </div>
            <!-- <div class="search_container">
                <form action="/action_page.php">
                    <input type="text" placeholder="Search.." name="search">
                </form>
            </div> -->
        </div>
        <!-- <div class="nav_container">
            <ul class="navbar_links">
                <li><a href="../data_page/renters_dashboard_1.php"><i class="fas fa-home"></i></a></li>
                <li><a href="../data_page/renters_dashboard_2.php"><i class="fas fa-home"></i></a></li>
                <li><a href="../data_page/renters_dashboard_3.php"><img src="../data_image/Personal Icon.png" class="icon" alt="personal_icon"></a></li>
            </ul>
        </div> -->
        <div class="profile_side">
            <div class="toggle_btn">
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <?php if ($udetails['profile_img'] == '') { ?>
                <img src="../data_style/assets/img/profile_icon.png" alt="Profile" class="rounded-circle">
                <?php } else { ?>
                <img src="../data_style/assets/profile/<?php echo $udetails['profile_img'] ?>" alt="Profile"
                    class="rounded-circle" width="40" height="40">
                <?php } ?>

                <span>
                    <?php
                        echo $_SESSION['tenant']['f_name'] ,' ',  $_SESSION['tenant']['s_name'];
                    ?>
                </span>
                <i class="fa-solid fa-caret-down"></i>
            </a>
            </div>
        </div>
    </div>
    <div class="dropdown_menu">
        <ul>
            <!-- <li class="dropdown_list active"><img src="../data_image/Home Icon.png" class="icon" alt="home_icon"><a href="../data_page/renters_dashboard_1.php" class="list active">Home</a></li> -->
            <!-- <li class="dropdown_list"><i class="fas fa-star"></i><a class="list" href="../data_page/Renters_Dashboard2.php">Inquiries</a></li> -->
            <li class="dropdown_list"><a class="list" href="../data_page/renters_dashboard_3.php"><i class="fas fa-user-alt">Profile</i></a></li>
            <li class="dropdown_list"><a class="list" href="../logout.php"><i class="fas fa-sign-out-alt">Logout</i></a></li>
        </ul>
    </div>

    <script src="../jscripts/dropdownfeat.js"></script>
</div>