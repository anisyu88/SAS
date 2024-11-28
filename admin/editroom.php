<?php
include('../db.php');

// Check if the room ID is set in the URL
if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];

    // Fetch room details from the database
    $query = "SELECT * FROM room WHERE room_id = '$room_id'";
    $result = mysqli_query($con, $query);
    $room = mysqli_fetch_assoc($result);

    if (isset($_POST['update'])) {
        // Get updated values from the form
        $capacity = $_POST['capacity'];
        $status = $_POST['status'];

        // Update the database with new values
        $update_query = "UPDATE room SET capacity = '$capacity', status = '$status' WHERE room_id = '$room_id'";
        if (mysqli_query($con, $update_query)) {
            // SweetAlert2 success notification
           // echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
           // SweetAlert2 success notification
              echo "<script>
              document.addEventListener('DOMContentLoaded', function() {
                  Swal.fire({
                      title: 'Success!',
                      text: 'Data has been successfully updated.',
                      icon: 'success'
                  }).then(function() {
                      window.location.href = 'room.php';
                  });
              });
              </script>";
        } else {
            // SweetAlert2 error notification
           // echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    title: 'Failed!',
                    text: 'Failed to update room details.',
                    icon: 'error'
                });
                </script>";
        }
    }
} else {
    echo "<script>
        alert('No room selected.');
        window.location.href='room.php';
        </script>";
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SAS - Admin </title>
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/logo1.png">
    <link rel="icon" type="image/png" href="assets/img/logo1.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="assets/fonts/line-icons.css">
    <!-- Main Style -->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <!-- Responsive Style -->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
     <!-- SweetAlert2 CSS and JavaScript --><!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="../sweetalert2/package/dist/sweetalert2.min.css">


  </head>

  <body>
    <div class="app header-default side-nav-light sidenav-expand">
      <div class="layout">
       <!-- Header START -->
       <div class="header navbar">
        <div class="header-container">
          <div class="nav-logo">
            <a href="dashboard.php">
              <b><img src="assets/img/logo1.png" alt="" style="width: 50px; height: auto;"></b>
              <span class="logo">
                <img src="assets/img/uptm.png" alt="" style="width: 120px; height: 57px;">
              </span>
            </a>
          </div>
          <ul class="nav-left">
            <li>
              <a class="sidenav-fold-toggler" href="javascript:void(0);">
                <i class="lni-menu"></i>
              </a>
              <a class="sidenav-expand-toggler" href="javascript:void(0);">
                <i class="lni-menu"></i>
              </a>
            </li>
          </ul>
          <ul class="nav-right">
            <li class="user-profile dropdown dropdown-animated scale-left">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="lni-user"></i>
              </a>
              <ul class="dropdown-menu dropdown-md">
                <li>
                  <a href="logout.php">
                    <i class="lni-lock"></i>
                    <span>Logout</span>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <!-- Header END -->
     
        <!-- Side Nav START -->
        <div class="side-nav expand-lg" style="background-color:#004898">
           <div class="side-nav-inner text-light">
             <ul class="side-nav-menu">
              <li class="side-nav-header">
              <span>Navigation</span>
              </li>
              <li class="nav-item dropdown">
                <li class="active">
                  <a href="dashboard.php" class="dropdown-toggle">
                    <span class="icon-holder">
                      <i class="lni-grid"></i>
                    </span>
                    <span class="title">Dashboard</span>
                  </a>
                </li>
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="dropdown-toggle">
                  <span class="icon-holder">
                    <i class="lni-layers"></i>
                  </span>
                  <span class="title">Apply</span>
                  <span class="arrow">
                    <i class="lni-chevron-right"></i>
                  </span>
                </a>
                <ul class="dropdown-menu sub-down">
                  <li>
                    <a href="apply_pending.php">
                      <span class="icon-holder">
                        <i class="lni-users"></i>
                      </span>Pending Student
                    </a>
                  </li>
                </ul>
                <ul class="dropdown-menu sub-down">
                  <li>
                    <a href="apply_approve.php">
                      <span class="icon-holder">
                        <i class="lni-check-mark-circle"></i>
                      </span>Approved Student
                    </a>
                  </li>
                </ul>
                <ul class="dropdown-menu sub-down">
                  <li>
                    <a href="apply_rejected.php">
                      <span class="icon-holder">
                        <i class="lni-close"></i>
                      </span>Rejected Student
                    </a>
                  </li>
                </ul>
              </li>
              
              <li class="nav-item dropdown">
                <a href="room.php" class="dropdown-toggle">
                  <span class="icon-holder">
                    <i class="lni-notepad"></i>
                  </span>
                  <span class="title">Room List</span>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="registered.php" class="dropdown-toggle">
                  <span class="icon-holder">
                    <i class="lni-apartment"></i>
                  </span>
                  <span class="title">Registered List</span>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="checkout.php" class="dropdown-toggle">
                  <span class="icon-holder">
                    <i class="lni-book"></i>
                  </span>
                  <span class="title">Check Out List</span>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="view_student.php" class="dropdown-toggle">
                  <span class="icon-holder">
                    <i class="lni-package"></i>
                  </span>
                  <span class="title" >Managed Student</span>
                </a>
              </li>
               <li class="nav-item dropdown">
                 <a href="faq_admin.php" class="dropdown-toggle"  >
                   <span class="icon-holder">
                     <i class="lni-bulb"></i>
                   </span>
                   <span class="title" >Frequently Ask Question</span>
                 </a>
               </li>
          </div>
        </div>
        <!-- Side Nav END -->

        <!-- Page Container START -->
        <div class="page-container">
          <!-- Content Wrapper START -->
          <div class="main-content">
            <div class="container-fluid">
              <!-- Breadcrumb Start -->
              <div class="breadcrumb-wrapper row">
                <div class="col-12 col-lg-3 col-md-6">
                  <h4 class="page-title">Room Information</h4>
                </div>
                <div class="col-12 col-lg-9 col-md-6">
                  <ol class="breadcrumb float-right">
                    <li><a href="#">Room</a></li>
                    <li class="active"> / Information Table</li>
                  </ol>
                </div>
              </div>
              <!-- Breadcrumb End -->
            </div>

            <div class="container-fluid">
              <div class="row">
                
                <div class="col-12">
                  <div class="card">
                    <div class="card-header border-bottom">
                      <h4 class="card-title">EDIT HOUSE</h4>
                    </div>
                    <div class="card-body">
                      <form class="forms-sample" action="" method="POST">
                        <div class="form-group row">
                          <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Room Name/ Number</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="room" value="<?php echo $room['room']; ?>" disabled>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Capacity</label>
                          <div class="col-sm-9">
                            <input type="number" class="form-control"name="capacity" value="<?php echo $room['capacity']; ?>" >
                          </div>
                        </div>
                        
                        <div class="form-group row">
                          <label  class="col-sm-3 col-form-label">Status</label>
                          <div class="col-sm-9">
                            <select name="status" class="form-control" >
                               <option value="<?php echo $room['status']; ?>" > </option>
                                <option value="available" <?php if ($room['status'] == 'available') echo 'selected'; ?>>Available</option>
                                <option value="booked" <?php if ($room['status'] == 'booked') echo 'selected'; ?>>Booked</option>
                                <option value="maintenance" <?php if ($room['status'] == 'maintenance') echo 'selected'; ?>>Under Maintenance</option>
                            </select>
                          </div>
                        </div>
                        
                        
                        <button type="submit" name="update" class="btn btn-success mr-3">Submit</button>
                        <a href="room.php" id="cancelButton" class="btn btn-secondary">Cancel</a>
                      </form>
                    </div>
                  </div>
                </div>
                
                
              </div>
            </div>

          </div>
          <!-- Content Wrapper END -->

          <!-- Footer START -->
          <footer class="content-footer">
            <div class="footer">
              <div class="copyright">
                <span>Copyright © 2024 <b class="text-dark">Siswi Accomodation System</b>. All Right Reserved</span>
                <span class="go-right">
                  <a href="" class="text-gray">Term &amp; Conditions</a>
                  <a href="" class="text-gray">Privacy &amp; Policy</a>
                </span>
              </div>
            </div>
          </footer>
          <!-- Footer END -->
        </div>
        <!-- Page Container END -->
      </div>
    </div>

    <!-- Preloader -->
    <div id="preloader">
      <div class="loader" id="loader-1"></div>
    </div>
    <!-- End Preloader -->

     <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="assets/js/jquery-min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.app.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- Link to SweetAlert2 JavaScript -->
    <script src="../sweetalert2/package/dist/sweetalert2.min.js"></script>
    <script>
    document.getElementById('cancelButton').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent the default button action if necessary
        Swal.fire({
            title: "Are you sure?",
            text: "Any unsaved changes will be lost.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, stay here!',
            reverseButtons: true // Optional: changes the order of buttons
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'room.php';  // Redirect to profile or appropriate page
            }
        });
    });
</script>


  </body>
</html>