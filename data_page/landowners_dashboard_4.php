<?php
require_once '../mysql/conn.php';

session_start();
if (!isset($_SESSION["land"])) {
   header("Location: ../data_page/landowners_login.php");
}
if (isset($_GET['delete'])) {
   $id = $_GET['delete'];
   $adn = "DELETE FROM  house_rentals  WHERE  house_id = ?";
   $stmt = $mydb->getConnection()->prepare($adn);
   $stmt->bind_param('s', $id);
   $stmt->execute();
   $stmt->close();
   if ($stmt) {
     $success = "Deleted" && header("refresh:1; url=landowners_dashboard_4.php");
   } else {
     $err = "Try Again Later";
   }
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
                <li class="active"><a href="..\data_page\landowners_dashboard_4.php">Manage Properties</a></li>
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
                <li><a href="..\logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="main">
        <div class="header-wrap">
            <div class="header-title">
                <ol>
                    <li><a href="../data_page/landowners_dashboard.php">Dashboard</a></li>
                    <li>Manage Properties</li>
                </ol>
                <h2>Manage Properties</h2>
            </div>
        </div>
        <div class="data_properties">
            <div class="row">
                <div class="col">
                  <div class="card shadow">
                    <div class="card-header border-0">
                      <a href="add_prop.php" class="btn btn-outline-success">
                        <i class="fas fa-utensils"></i>
                        Add New Property
                      </a>
                      <i class="fas fa-search" style="float:right"><input type="text" id="search" placeholder="Search items" style="font-family: Arial"></i>
                    </div>
                    <div class="table-responsive">
                      <table class="table align-items-center table-flush" id="example1">
                        <thead class="thead-light">
                          <tr>
                            <th scope="col">House Name</th>
                            <th scope="col">Rental Type</th>
                            <th scope="col">Price</th>
                            <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ret = "SELECT * FROM  house_rentals WHERE landowner_userid = ?";
                        $stmt = $mydb->getConnection()->prepare($ret);
                        $stmt->bind_param('s', $_SESSION['land']['userid']);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($prod = $res->fetch_object()) {
                            ?>
                            <tr>
                                <td data-searchable="true"><?php echo $prod->house_name; ?></td>
                                <td data-searchable="true"><?php echo $prod->house_type; ?></td>
                                <td>₱ <?php echo $prod->rent_amount; ?></td>
                                <td>
                                    <a href="Landowners_Dashboard_4.php?delete=<?php echo $prod->house_id; ?>">
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </button>
                                    </a>
                                    <!--<a href="update_product.php?update=<?php echo $prod->house_id; ?>">
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                            Update
                                        </button>
                                    </a>-->
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                      </taable>
                    </div>
                  </div>
            </div>
      </div>
    </div>
      <!-- Argon Scripts -->
      <?php
      require_once('../data_style/_scripts.php');
      ?>
      <script>
      $(document).ready(function() {
        // Add event listener for search input
        $('#search').on('keyup', function() {
          var searchText = $(this).val().toLowerCase();

          // Iterate through each row in the table body
          $('#example1 tbody tr').each(function() {
            var row = $(this);
            var showRow = false;

            // Iterate through each searchable column in the row
            row.find('td[data-searchable="true"]').each(function() {
              var cellText = $(this).text().toLowerCase();

              // If the cell contains the search text, show the row and break the loop
              if (cellText.includes(searchText)) {
                showRow = true;
                return false; // Break the loop
              }
            });

            // Toggle the visibility of the row based on the search result
            row.toggle(showRow);
          });
        });
      });
    </script>
  </body>
</html>