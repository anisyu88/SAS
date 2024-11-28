<?php
session_start();
include('../db.php');

// Check if the student is logged in
if (isset($_SESSION['studid'])) {
    // If the student is logged in, retrieve the student ID from the session
    $studid = $_SESSION['studid'];
    echo "<script>console.log('Student ID is: " . $studid . "');</script>";
} else {
    // If not logged in, redirect to the login page and stop script execution
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

// Fetch current student information from the 'student' table
$student_query = "SELECT studid, studname, mail, pass, program, noic, nophone, sem, sponsorship, parentsno, status FROM student WHERE studid = ?";
$stmt = $con->prepare($student_query);
$stmt->bind_param("s", $studid);  // Bind the student ID
$stmt->execute();
$student_result = $stmt->get_result();

if ($student_result->num_rows > 0) {
    // Fetch the student data
    $student = $student_result->fetch_assoc();
    $studname = htmlspecialchars($student['studname']);
    $mail = htmlspecialchars($student['mail']);
    $pass = htmlspecialchars($student['pass']);
    $program = htmlspecialchars($student['program']);
    $noic = htmlspecialchars($student['noic']);
    $nophone = htmlspecialchars($student['nophone']);
    $sem = htmlspecialchars($student['sem']);
    $sponsorship = htmlspecialchars($student['sponsorship']);
    $parentsno = htmlspecialchars($student['parentsno']);
    $status = htmlspecialchars($student['status']);
} else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Student information not found.',
            icon: 'error',
        });
    </script>";
    exit;
}

// Handle form submission for updating the student information
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Sanitize and fetch new/edited values from the form
    $studname = filter_var($_POST['studname'], FILTER_SANITIZE_STRING);
    $mail = filter_var($_POST['mail'], FILTER_SANITIZE_STRING);
    $program = filter_var($_POST['program'], FILTER_SANITIZE_STRING);
    $noic = filter_var($_POST['noic'], FILTER_SANITIZE_STRING);
    $nophone = filter_var($_POST['nophone'], FILTER_SANITIZE_STRING);
    $sem = filter_var($_POST['sem'], FILTER_SANITIZE_NUMBER_INT);
    $sponsorship = filter_var($_POST['sponsorship'], FILTER_SANITIZE_STRING);
    $parentsno = filter_var($_POST['parentsno'], FILTER_SANITIZE_STRING);
    $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
    
    // Prepare the UPDATE SQL statement to update the student's information
    $update_query = "UPDATE student SET studname = ?, mail=?, program = ?, noic = ?, nophone = ?, sem = ?, sponsorship=?, parentsno=? WHERE studid = ?";
    $update_stmt = $con->prepare($update_query);
    $update_stmt->bind_param("sssssisss", $studname, $mail, $program, $noic, $nophone, $sem, $sponsorship, $parentsno, $studid);
    
    if ($update_stmt->execute()) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'Success',
                    text: 'Student information updated successfully.',
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
                    title: 'Error',
                    text: 'Failed to update student information: " . $update_stmt->error . "',
                    icon: 'error',
                });
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SAS - Student</title>
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
    <div class="app header-default side-nav-light">
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
              <h4 class="page-title">Edit Profile</h4>
            </div>

            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header border-bottom">
                      <h4 class="card-title">Student Profile</h4>
                    </div>
                    <div class="card-body">
                      <form class="forms-sample" method="POST">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Full Name:</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="studname" value="<?php echo $studname; ?>" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Student ID:</label>
                          <div class="col-sm-9">
                            <input type="text" name="studid" class="form-control" value="<?php echo $studid; ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Email:</label>
                          <div class="col-sm-9">
                            <input type="text" name="mail" class="form-control" value="<?php echo $mail; ?>" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label  class="col-sm-3 col-form-label"> Program: </label>
                          <div class="col-sm-9">
                            <select name="program" class="form-control" value="<?php echo $program; ?>" required>
                              <option value="">--Select Program--</option>
                              <option value="ACCA" <?php echo $program == 'ACCA' ? 'selected' : ''; ?>>Association of Chartered Certified Accountants (ACCA) Professional Qualification</option>
                              <option value="AA103" <?php echo $program == 'AA103' ? 'selected' : ''; ?>>Diploma of Accountancy (AA103)</option>
                              <option value="CC101" <?php echo $program == 'CC101' ? 'selected' : ''; ?>>Diploma in Computer Science (CC101)</option>
                              <option value="BK101" <?php echo $program == 'BK101' ? 'selected' : ''; ?>>Diploma in Corporate Communication (BK101)</option>
                              <option value="AA201" <?php echo $program == 'AA201' ? 'selected' : ''; ?>>Bachelor of Accountancy (Honours) (AA201)</option>
                              <option value="BE201" <?php echo $program == 'BE201' ? 'selected' : ''; ?>>Bachelor of Arts (Hons) in Applied English Language Studies (BE201)</option>
                              <option value="BE202" <?php echo $program == 'BE202' ? 'selected' : ''; ?>>Bachelor of Early Childhood Education (BE202)</option>
                              <option value="BE203" <?php echo $program == 'BE203' ? 'selected' : ''; ?>>Bachelor of Education (Honours) in Teaching English As A Second Language (TESL) (BE203)</option>
                              <option value="CM201" <?php echo $program == 'CM201' ? 'selected' : ''; ?>>Bachelor of Arts in 3D Animation and Digital Media (CM201)</option>
                              <option value="AB201" <?php echo $program == 'AB201' ? 'selected' : ''; ?>>Bachelor of Business Administration Human Resource Management (AB201)</option>
                              <option value="AC201" <?php echo $program == 'AC201' ? 'selected' : ''; ?>>Bachelor of Corporate Administration(AC201)</option>
                              <option value="AB202" <?php echo $program == 'AB202' ? 'selected' : ''; ?>>Bachelor of Business Administration (AB202)</option>
                              <option value="BK201" <?php echo $program == 'BK201' ? 'selected' : ''; ?>>Bachelor of Communication (Hons) in Corporate Communication (BK201)</option>
                              <option value="CT203" <?php echo $program == 'CT203' ? 'selected' : ''; ?>>Bachelor of Information Technology in Business Computing (CT203)</option>
                              <option value="CT204" <?php echo $program == 'CT204' ? 'selected' : ''; ?>>Bachelor of Information Technology (Honours) in Computer Application Development (CT204)</option>
                              <option value="CT206" <?php echo $program == 'CT206' ? 'selected' : ''; ?>>Bachelor of Information Technology (Honours) in Cyber Security (CT206)</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Identity Card Number:</label>
                          <div class="col-sm-9">
                            <input type="text" name="noic" class="form-control" value="<?php echo $noic; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="12" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Semester:</label>
                          <div class="col-sm-9">
                            <input type="number" class="form-control" name="sem" value="<?php echo $sem; ?>" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Telephone Number:</label>
                          <div class="col-sm-9">
                            <input type="text" name="nophone" class="form-control" value="<?php echo $nophone; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="12" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label  class="col-sm-3 col-form-label">Status:</label>
                          <div class="col-sm-9">
                            <input type="text" name="status" class="form-control" value="<?php echo $status; ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label"> Sponsorship </label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="sponsorship" value="<?php echo $sponsorship ?>" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label  class="col-sm-3 col-form-label"> Parent's Phone Number: </label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="parentsno" value="<?php echo $parentsno ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="12" required>
                          </div>
                        </div>

                        <!-- Add other fields here similarly -->
                        <div class="form-group row justify-content-end">
                          <button type="submit" class="btn btn-success mr-3">Save Changes</button>
                          <button id="cancelButton" class="btn btn-danger mr-3">Cancel</button>
                        </div>
                      </form>
                      <hr>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Download Booking PDF:</label>
                        <div class="col-sm-9">
                          <a href="booking_invoice/<?php echo $_SESSION['studid']; ?>_booking.pdf" class="btn btn-common" download>Download Your Booking PDF</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Content Wrapper END -->
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
        // Cancel button handler
        const cancelButton = document.getElementById('cancelButton');
        if (cancelButton) {
            cancelButton.addEventListener('click', function(e) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Any unsaved changes will be lost.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel',
                    cancelButtonText: 'No, keep editing'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'profile.php';  // Redirect to profile or appropriate page
                    }
                });
            });
        }
    });
    </script>

  </body>
</html>
