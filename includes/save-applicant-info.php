<?php
session_start();
date_default_timezone_set('Asia/Manila');
require_once '../mysql/conn.php';

$userid = $_SESSION['tenant']['userid'];

if (isset($_POST['saveparent'])) {
    var_dump($_POST);
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $municipality = $_POST['municipality'];
    $zipcode = $_POST['zipcode'];
    $father_name = $_POST['father_name'];
    $father_contact = $_POST['father_contact'];
    $father_occupation = $_POST['father_occupation'];
    $mother_name = $_POST['mother_name'];
    $mother_contact = $_POST['mother_contact'];
    $mother_occupation = $_POST['mother_occupation'];

    // Check if the user already has a parent record
    $select_parentdetails = "SELECT * FROM parent_details WHERE userid='$userid'";
    $resultparent = $conn->query($select_parentdetails);

    if ($resultparent->num_rows > 0) {
        // Update existing parent record
        $update_parent_details = "UPDATE parent_details SET father_name='$father_name', father_contact='$father_contact',
        father_occupation='$father_occupation', mother_name='$mother_name', mother_contact='$mother_contact',
        mother_occupation='$mother_occupation' WHERE userid='$userid'";

        if ($conn->query($update_parent_details) === TRUE) {
            header('location:../../data_page/renters_dashboard_3.php?success=parentdata');
        }
    } else {
        // Insert new parent record
        $insert_parent_data = "INSERT INTO parent_details (father_name, father_contact, father_occupation,
        mother_name, mother_contact, mother_occupation, userid)
        VALUES ('$father_name', '$father_contact', '$father_occupation', '$mother_name', '$mother_contact',
        '$mother_occupation', '$userid')";

        if ($conn->query($insert_parent_data) === TRUE) {
            header('location:../../data_page/renters_dashboard_3.php?success=parentdata');
        }
    }

    // Check if the user already has an address record
    $select_address = "SELECT * FROM tenants_address WHERE userid='$userid'";
    $resultaddress = $conn->query($select_address);

    if ($resultaddress->num_rows > 0) {
        // Update existing address record
        $update_address = "UPDATE tenants_address SET st_house_num='$street', barangay='$barangay',
        municipality='$municipality', province='Laguna', postal_code='$zipcode' WHERE userid='$userid'";

        if ($conn->query($update_address) === TRUE) {
             header('location:../../data_page/renters_dashboard_3.php?success=parentdata');
        }
    } else {
        // Insert new address record
        $insert_address = "INSERT INTO tenants_address (st_house_num, barangay, municipality, province,
        postal_code, userid)
        VALUES ('$street', '$barangay', '$municipality', 'Laguna', '$zipcode', '$userid')";

        if ($conn->query($insert_address) === TRUE) {
             header('location:../../data_page/renters_dashboard_3.php?success=parentdata');
        }
    }

} else if (isset($_POST['savepersonal'])) {
    var_dump($_POST);
    $f_name = $_POST['f_name'];
    $m_name = $_POST['m_name'];
    $s_name = $_POST['s_name'];
    $birthdate = $_POST['birthdate'];
    $birthplace = $_POST['birthplace'];
    $citizenship = $_POST['citizenship'];
    $email = $_POST['email'];
    $num = $_POST['num'];
    $civil_status = $_POST['civil_status'];
    $gender = $_POST['gender'];
    $education_status = $_POST['education_status'];
    $social_media_link = $_POST['social_media_link'];

    $currentDate = date("Y-m-d");
    $age = date_diff(date_create($birthdate), date_create($currentDate))->y;

    // Check if the user already has a profile record
    $select_profiledetails = "SELECT * FROM tbl_renters_account WHERE userid='$userid'";
    $resultprofile = $conn->query($select_profiledetails);

    if ($resultprofile->num_rows > 0) {
        // Update existing profile record
        $update_details = "UPDATE tbl_renters_account SET f_name='$f_name', m_name='$m_name', s_name='$s_name', email='$email', num='$num',
        birthdate='$birthdate', birthplace='$birthplace', citizenship='$citizenship', civil_status='$civil_status',
        age='$age', gender='$gender', education_status='$education_status', social_media_link='$social_media_link'
        WHERE userid='$userid'";

        if ($conn->query($update_details) === TRUE) {
            header('location:../../data_page/renters_dashboard_3.php?success=personaldata');
        }
    } else {
        // Insert new profile record
        $insert_profile_data = "INSERT INTO tbl_renters_account (f_name, m_name, s_name, email, num, birthdate, birthplace,
        citizenship, civil_status, age, gender, education_status, social_media_link, userid)
        VALUES ('$f_name', '$m_name', '$s_name', '$email', '$num', '$birthdate', '$birthplace', '$citizenship',
        '$civil_status', '$age', '$gender', '$education_status', '$social_media_link', '$userid')";

        if ($conn->query($insert_profile_data) === TRUE) {
            header('location:../../data_page/renters_dashboard_3.php?success=personaldata');
        }
    }
}
?>
