<?php 
session_start();
include('../db.php');

// Check if the student is logged in
if (!isset($_SESSION['studid'])) {
    // If not logged in, include SweetAlert2 and show the error message
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Student ID not found. Please log in.',
            icon: 'error',
        }).then(function() {
            window.location.href = 'login.php';
        });
    </script>";
    exit;
} 

// If logged in, retrieve the student ID from the session
$studid = $_SESSION['studid'];

// Check the database connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch room details (room_number) for the booked rooms
$rooms_query = "
    SELECT booking.bookingid, room.room_id, room.room
    FROM booking 
    JOIN room ON booking.room_id = room.room_id 
    WHERE booking.studid = ?
";

// Prepare the SQL statement
$stmt_rooms = $con->prepare($rooms_query);

// Check if preparation was successful
if (!$stmt_rooms) {
    die("Error preparing SQL statement: " . $con->error);
}

// Bind the parameter
$stmt_rooms->bind_param("s", $studid);

// Execute the statement
$stmt_rooms->execute();

// Get the result set
$rooms_result = $stmt_rooms->get_result();

// Check if the query execution was successful
if (!$rooms_result) {
    die("Failed to fetch rooms: " . $con->error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Student table data
    $studname = filter_var($_POST['studname'], FILTER_SANITIZE_STRING);
    $program = filter_var($_POST['program'], FILTER_SANITIZE_STRING);
    $noic = filter_var($_POST['noic'], FILTER_SANITIZE_STRING);
    $nophone = filter_var($_POST['nophone'], FILTER_SANITIZE_STRING);
    $sem = filter_var($_POST['sem'], FILTER_SANITIZE_NUMBER_INT);
    $sponsorship = filter_var($_POST['sponsorship'], FILTER_SANITIZE_STRING);
    $parentsno = filter_var($_POST['parentsno'], FILTER_SANITIZE_STRING);
    $status = "registered";

    // Register table data
    $agreement = filter_var($_POST['agreement'], FILTER_SANITIZE_STRING);
    $acknowledge = filter_var($_POST['acknowledge'], FILTER_SANITIZE_STRING);
    $bookingid = filter_var($_POST['room'], FILTER_SANITIZE_NUMBER_INT); // Fetch bookingid from the dropdown
    $register_date = filter_var($_POST['register_date'], FILTER_SANITIZE_STRING);

    // Check if the booking_id exists in the booking table
    $check_booking_query = "SELECT bookingid FROM booking WHERE bookingid = ?";
    $stmt_check = $con->prepare($check_booking_query);

    if (!$stmt_check) {
        die("Error preparing check_booking_query statement: " . $con->error);
    }

    $stmt_check->bind_param("i", $bookingid);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows == 0) {
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Booking ID does not exist. Please select a valid room.',
                icon: 'error',
            });
        </script>";
    } else {
        // Prepare SQL statement for insertion into the student table
        $stmt_student = $con->prepare("INSERT INTO student (studid, studname, program, noic, nophone, sem, sponsorship, parentsno, status) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                                        ON DUPLICATE KEY UPDATE studname=?, program=?, noic=?, nophone=?, sem=?, sponsorship=?, parentsno=?, status=?");

        if (!$stmt_student) {
            die("Error preparing student insert statement: " . $con->error);
        }

        $stmt_student->bind_param("sssssisssssssisss", $studid, $studname, $program, $noic, $nophone, $sem, $sponsorship, $parentsno, $status,
            $studname, $program, $noic, $nophone, $sem, $sponsorship, $parentsno, $status);

        // Prepare SQL statement for insertion into the registration table
        $stmt_register = $con->prepare("INSERT INTO registration (studid, agreement, acknowledge, booking_id, register_date) 
                                        VALUES (?, ?, ?, ?, ?)");

        if (!$stmt_register) {
            die("Error preparing register insert statement: " . $con->error);
        }

        $stmt_register->bind_param("sssis", $studid, $agreement, $acknowledge, $bookingid, $register_date);

        // Execute both statements
        $success_student = $stmt_student->execute();
        $success_register = $stmt_register->execute();

        // After form submission and database checks
          if ($success_student && $success_register) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        title: 'Success',
                        text: 'Thank you for registering.',
                        icon: 'success',
                    }).then(function () {
                        window.location.href = 'profile.php';
                    });
                });
            </script>";
          } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        title: 'Failed',
                        text: 'Failed to register the application. Please try again later.',
                        icon: 'error',
                    });
                });
            </script>";
          }

        // Close the statements
        $stmt_student->close();
        $stmt_register->close();
    }

    // Close the check booking statement
    $stmt_check->close();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SAS - Student </title>
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
    <link rel="stylesheet" href="../sweetalert2/package/dist/sweetalert2.min.css">

  </head>

  <body>
    <div class="app header-default side-nav-inverse-danger ">
      <div class="layout">
       <!-- Header START -->
       <div class="header navbar">
        <div class="header-container">
          <div class="nav-logo">
            <a href="home.php">
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
                  <a href="profile.php">
                    <i class="lni-user"></i>
                    <span>Profile</span>
                  </a>
                </li>
                
                <li>
                  <a href="login.php">
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
                <div class="side-nav-inner">
                    <ul class="side-nav-menu">
                        <li class="side-nav-header">
                            <span>Navigation</span>
                        </li>
                        <li class="nav-item dropdown <?php echo $current_page == 'home.php' ? 'active' : ''; ?>">
                            <a href="home.php" class="dropdown-toggle">
                                <span class="icon-holder">
                                    <i class="lni-cloud"></i>
                                </span>
                                <span class="title">Home</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown <?php echo $current_page == 'apply.php' ? 'active' : ''; ?>">
                            <a href="apply.php" class="dropdown-toggle">
                                <span class="icon-holder">
                                    <i class="lni-pencil-alt"></i>
                                </span>
                                <span class="title">Apply For Accommodation</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown <?php echo $current_page == 'applicationstatus.php' ? 'active' : ''; ?>">
                            <a href="applicationstatus.php" class="dropdown-toggle">
                                <span class="icon-holder">
                                    <i class="lni-check-mark-circle"></i>
                                </span>
                                <span class="title">Application Status</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown <?php echo $current_page == 'register.php' ? 'active' : ''; ?>">
                            <a href="register.php" class="dropdown-toggle">
                                <span class="icon-holder">
                                    <i class="lni-home"></i>
                                </span>
                                <span class="title">Register for Siswi</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown <?php echo $current_page == 'checkout.php' ? 'active' : ''; ?>">
                            <a href="checkout.php" class="dropdown-toggle">
                                <span class="icon-holder">
                                    <i class="lni-exit"></i>
                                </span>
                                <span class="title">Check Out</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown <?php echo $current_page == 'faq_student.php' ? 'active' : ''; ?>">
                            <a href="faq_student.php" class="dropdown-toggle">
                                <span class="icon-holder">
                                    <i class="lni-bulb"></i>
                                </span>
                                <span class="title">FAQ</span>
                            </a>
                        </li>
                    </ul>
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
                  <h4 class="page-title">Register</h4>
                </div>
                
            
              </div>
              <!-- Breadcrumb End -->
            </div>

            <div class="container-fluid">
              <div class="row">
                
                <div class="col-12">
                  <div class="card">
                    <div class="card-header border-bottom">
                      <h4 class="card-title">Register For Accomodation</h4>
                    </div>
                    <div class="card-body">
                      <h4> STUDENT DETAILS SECTION</h4>
                      <p class="card-description">
                        You are required to fill in everything  
                      </p>
                      <form class="forms-sample" method="POST" action="register.php">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Full Name:</label>
                          <div class="col-sm-9">
                            <input type="text" name="studname" class="form-control" placeholder="Full Name" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Student ID:</label>
                          <div class="col-sm-9">
                          <label class="form-control"> 
                                <?php echo htmlspecialchars($_SESSION['studid']); ?>
                              </label>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label  class="col-sm-3 col-form-label"> Program: </label>
                          <div class="col-sm-9">
                            <select name="program" class="form-control" required>
                              <option value="">--Select Program--</option>
                              <option value="ACCA">Association of Chartered Certified Accountants (ACCA) Professional Qualification</option>
                              <option value="AA103">Diploma of Accountancy (AA103)</option>
                              <option value="CC101">Diploma in Computer Science (CC101)</option>
                              <option value="BK101">Diploma in Corporate Communication (BK101)</option>
                              <option value="AA201">Bachelor of Accountancy (Honours) (AA201)</option>
                              <option value="BE201">Bachelor of Arts (Hons) in Applied English Language Studies (BE201) </option>
                              <option value="BE202">Bachelor of Early Childhood Education (BE202)</option>
                              <option value="BE203">Bachelor of Education (Honours) in Teaching English As A Second Language (TESL) (BE203)</option>
                              <option value="CM201">Bachelor of Arts in 3D Animation and Digital Media (CM201)</option>
                              <option value="AB201">Bachelor of Business Administration Human Resource Management (AB201)</option>
                              <option value="AC201">Bachelor of Corporate Administration(AC201)</option>
                              <option value="AB202">Bachelor of Business Administration (AB202)</option>
                              <option value="BK201">Bachelor of Communication (Hons) in Corporate Communication (BK201) </option>
                              <option value="CT203">Bachelor of Information Technology in Business Computing (CT203)</option>
                              <option value="CT204">Bachelor of Information Technology (Honours) in Computer Application Development (CT204)</option>
                              <option value="CT206">Bachelor of Information Technology (Honours) in Cyber Security (CT206)</option> 
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label  class="col-sm-3 col-form-label">Identity Card Number :</label>
                          <div class="col-sm-9">
                            <input type="number" name="noic" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="12"  placeholder="Your Identity Card Number " required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label  class="col-sm-3 col-form-label">Telephone Number:</label>
                          <div class="col-sm-9">
                            <input type="number" name="nophone" class="form-control"  placeholder="Your Telephone Number" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="12" required>
                          </div>
                        </div>
                        
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Semester:</label>
                          <div class="col-sm-9">
                            <input type="number" name="sem" class="form-control"  placeholder="Your Current Semester" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="12" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label  class="col-sm-3 col-form-label"> Sponsorship</label>
                          <div class="col-sm-9">
                            <input type="text" name="sponsorship" class="form-control"  placeholder="Your Current Sponsorship"  required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label  class="col-sm-3 col-form-label"> Parent's Phone Number: </label>
                          <div class="col-sm-9">
                            <input type="text" name="parentsno" class="form-control"  placeholder="Your Parent's Number Telephone" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="12" required>
                          </div>
                        </div>
                        <hr> 
                        <!--AGREEMENT SECTION (2)-->
                        <h4> AGREEMENT SECTION</h4>
                        <p class="card-description">
                            I, the undersigned, agree that I will reside at Universiti Poly-Tech Malaysia for one (1) semester,
                            unless otherwise instructed by the university authorities. I will not leave university accommodation without permission
                            and will not stay outside university premises without proper authorization.
                        </p>

                          <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="agreement" name="agreement" value="true" required >
                            <label class="form-check-label" for="agreement" >
                              I agree to abide by the rules and regulations mentioned in the 
                              <a href="#" class="text-primary">2019 Universiti Poly-Tech Mara Student Handbook</a>. 
                              I accept that failure to comply may result in disciplinary action.
                            </label>
                          </div>
                          <hr> 
                          <!--ACKNOWLEDGEMENT SECTION (3)-->
                          <h4> --ACKNOWLEDGEMENT SECTION</h4>
                          <div class="form-group row">
                            <label for="room" class="col-sm-3 col-form-label">Room Number: </label>
                            <div class="col-sm-9">
                              <select name="room" id="room" class="form-control" id="room" required>
                                <option>Select Room Number</option>
                                <?php
                                // Populate the dropdown with rooms from the 'booking' and 'room' tables
                                while ($room = $rooms_result->fetch_assoc()) {
                                    echo '<option value="' . htmlspecialchars($room['bookingid']) . '">' . htmlspecialchars($room['room']) . '</option>';
                                }
                                ?>

                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Register Date:</label>
                            <div class="col-sm-9">
                              <input type="date" class="form-control" name="register_date" required>
                            </div>
                          </div>
                          <br>
                          <p class="card-description">
                            I hereby acknowledge that I have read and understood all the terms and conditions of the residency program. 
                            I confirm my responsibility to comply with the stipulated regulations.
                        </p>

                          <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="acknowledge" name="acknowledge" value="true" required >
                            <label class="form-check-label" for="acknowledge">
                                I acknowledge and accept the terms and conditions of the residency program.
                            </label>
                          </div>
                          <div class="text-center">
                            <button type="submit" class="btn btn-success mr-3">Submit</button>
                            <button id="cancelButton" class="btn btn-danger">Cancel</button>
                          </div>

                        
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
    <script src="../sweetalert2/package/dist/sweetalert2.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const cancelButton = document.getElementById('cancelButton');
        if (cancelButton) {
            cancelButton.addEventListener('click', function(e) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "Any unsaved changes will be lost.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel',
                    cancelButtonText: 'No, keep editing'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'register.php';  // Redirect to register or appropriate page
                    }
                });
            });
        }
    });
</script>


  </body>
</html>