<?php 
session_start();
include('../db.php');

// active
$current_page = basename($_SERVER['PHP_SELF']);

// Check if the student is logged in
if (isset($_SESSION['studid'])) {
    $studid = $_SESSION['studid'];
    echo "<script>console.log('Student ID is: " . $studid . "');</script>";
} else {
    // SweetAlert2 error notification for login requirement
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Student ID not found. Please log in.',
            icon: 'error'
        }).then(function() {
            window.location.href = 'login.php';
        });
    </script>";
    exit;
}

// Fetch room details
$rooms_query = "SELECT booking.bookingid, room.room_id, room.room FROM booking JOIN room ON booking.room_id = room.room_id WHERE booking.studid = ?";
$stmt_rooms = $con->prepare($rooms_query);

if (!$stmt_rooms) {
    die("Error preparing SQL statement: " . $con->error);
}

$stmt_rooms->bind_param("s", $studid);
$stmt_rooms->execute();
$rooms_result = $stmt_rooms->get_result();

if (!$rooms_result) {
    die("Failed to fetch rooms: " . $con->error);
}

// Fetch current student information
$student_query = "SELECT studid, studname, program, noic, nophone, sem, status FROM student WHERE studid = ?";
$stmt = $con->prepare($student_query);
$stmt->bind_param("s", $studid);
$stmt->execute();
$student_result = $stmt->get_result();

if ($student_result->num_rows > 0) {
    $student = $student_result->fetch_assoc();
    $studname = htmlspecialchars($student['studname']);
    $program = htmlspecialchars($student['program']);
    $noic = htmlspecialchars($student['noic']);
    $nophone = htmlspecialchars($student['nophone']);
    $sem = htmlspecialchars($student['sem']);
    $status = htmlspecialchars($student['status']);
} else {
  echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Student information not found.',
            icon: 'error'
        });
    </script>";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['imageFile']) && !empty($_FILES['imageFile']['name'])) {
        $target_dir = "checkout/";
        $file_name = basename($_FILES["imageFile"]["name"]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
          echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    title: 'Failed',
                    text: 'Only JPG, JPEG, and PNG files are allowed',
                    icon: 'warning'
                });
            </script>";
        } else {
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $target_file)) {
                // Process form data here
                $studname = filter_var($_POST['studname'], FILTER_SANITIZE_STRING);
                $program = filter_var($_POST['program'], FILTER_SANITIZE_STRING);
                $noic = filter_var($_POST['noic'], FILTER_SANITIZE_STRING);
                $nophone = filter_var($_POST['nophone'], FILTER_SANITIZE_STRING);
                $sem = filter_var($_POST['sem'], FILTER_SANITIZE_NUMBER_INT);
                $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
                $bookingid = filter_var($_POST['room'], FILTER_SANITIZE_NUMBER_INT);
                $return_key = filter_var($_POST['return_key'], FILTER_SANITIZE_STRING);
                $checkedout_date = filter_var($_POST['checkedout_date'], FILTER_SANITIZE_STRING);
                $checkout_reason = filter_var($_POST['checkout_reason'], FILTER_SANITIZE_STRING);

                // Update room occupancy
                $stmt_get_room = $con->prepare("SELECT current_occupancy, capacity FROM room WHERE room_id = (SELECT room_id FROM booking WHERE bookingid = ?)");
                $stmt_get_room->bind_param("i", $bookingid);
                $stmt_get_room->execute();
                $room_result = $stmt_get_room->get_result();
                
                if ($room_result->num_rows > 0) {
                    $room_data = $room_result->fetch_assoc();
                    $new_occupancy = $room_data['current_occupancy'] - 1;

                    $stmt_update_room = $con->prepare("UPDATE room SET current_occupancy = ? WHERE room_id = (SELECT room_id FROM booking WHERE bookingid = ?)");
                    $stmt_update_room->bind_param("ii", $new_occupancy, $bookingid);
                    $stmt_update_room->execute();

                    if ($new_occupancy < $room_data['capacity']) {
                        $stmt_update_status = $con->prepare("UPDATE room SET status = 'available' WHERE room_id = (SELECT room_id FROM booking WHERE bookingid = ?)");
                        $stmt_update_status->bind_param("i", $bookingid);
                        $stmt_update_status->execute();
                    }
                } else {
                  echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                    echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Room data not found.',
                            icon: 'error'
                        });
                    </script>";
                    exit;
                }

                // Insert into checkedout table
                $stmt_checkedout = $con->prepare("INSERT INTO checkedout (studid, bookingid, return_key, checkedout_date, checkout_reason, filename, filepath) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt_checkedout->bind_param("sisssss", $studid, $bookingid, $return_key, $checkedout_date, $checkout_reason, $file_name, $target_file);

                if ($stmt_checkedout->execute()) {
                    // Update student status to 'checked out'
                    $new_status = 'checked out';
                    $stmt_update_student_status = $con->prepare("UPDATE student SET status = ? WHERE studid = ?");
                    $stmt_update_student_status->bind_param("ss", $new_status, $studid);
                    $stmt_update_student_status->execute();
                    
                    //after form submission and datatabase checks

                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                    echo "<script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Swal.fire({
                            title: 'Success',
                            text: 'Check-out successful.',
                            icon: 'success'
                        }).then(function() {
                            window.location.href = 'home.php';
                        });
                    </script>";
                    
                } else {
                  echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                    echo "<script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Swal.fire({
                            title: 'Error',
                            text: 'Check-out failed.',
                            icon: 'error'
                        });
                    </script>";
                }

            } else {
              echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                    Swal.fire({
                        title: 'Warning',
                        text: 'Error uploading your file.',
                        icon: 'warning'
                    });
                </script>";
            }
        }
    } else {
      echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Warning',
                text: 'Please upload an image.',
                icon: 'warning'
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
    <title>SAS - STUDENT </title>
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
    <!-- SweetAlert2 CSS and JavaScript -->
    <link rel="stylesheet" href="../sweetalert2/package/dist/sweetalert2.min.css">
  </head>

  <body>
    <div class="app header-default side-nav-light sidenav-expand">
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
              <!-- Breadcrumb Start -->
              <div class="breadcrumb-wrapper row">
                <div class="col-12 col-lg-3 col-md-6">
                  <h4 class="page-title">Check Out</h4>
                </div>
                
              </div>
              <!-- Breadcrumb End -->
            </div>

            <div class="container-fluid">
              <div class="row">
                
                <div class="col-12">
                  <div class="card">
                    <div class="card-header border-bottom">
                      <h4 class="card-title">Check Out From Residence Form</h4>
                    </div>
                    <div class="card-body">
                      <p class="card-description">
                        You are required to fill in everything 
                      </p>
                      <form role="form" class="forms-sample" method="POST" enctype="multipart/form-data" action="checkout.php">
                        <div class="form-group row">
                          <label  class="col-sm-3 col-form-label">Full Name:</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?php echo $studname; ?>" name="studname" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label  class="col-sm-3 col-form-label">Student ID:</label>
                          <div class="col-sm-9">
                          <label class="form-control"> 
                                <?php echo htmlspecialchars($_SESSION['studid']); ?>
                              </label>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label"> Program: </label>
                          <div class="col-sm-9">
                          <select name="program" class="form-control" value="<?php echo $program; ?>" required>
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
                          <label  class="col-sm-3 col-form-label">Identity Card Number:</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="noic" value="<?php echo $noic; ?>" pattern="[0-9]*" inputmode="numeric" required >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Telephone Number:</label>
                          <div class="col-sm-9">
                            <input type="text" name="nophone" class="form-control"  value="<?php echo $nophone; ?>" pattern="[0-9]*" inputmode="numeric" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Semester:</label>
                          <div class="col-sm-9">
                            <input type="number" class="form-control" name="sem" value="<?php echo $sem; ?>"  required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Select Room Number:</label>
                          <div class="col-sm-9">
                            <select class="form-control" id="room" name="room">
                              <option value="">--Select Room-- </option>
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
                          <label  class="col-sm-3 col-form-label">Status:</label>
                          <div class="col-sm-9">
                            <select name="status" class="form-control" id="status" required>
                              <option value="">--Select Status--</option>
                              <option value="checked out">Checked Out</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Check Out Date:</label>
                          <div class="col-sm-9">
                            <input type="date" class="form-control" name="checkedout_date" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label  class="col-sm-3 col-form-label">Reason of Check Out:</label>
                          <div class="col-sm-9">
                            <select name="checkout_reason" class="form-control" id="" required>
                              <option value="">-- Select Reason --</option>
                              <option value="End of Semester">End of Semester</option>
                              <option value="Withdraw">Withdraw</option>
                              <option value="Room Transfer">Room Transfer</option>
                              <option value="Completion of studies">Completion of studies</option>
                            </select>
                          </div>
                        </div>
                        <hr> 
                        <!--KEY SUBMISSION SECTION (2)-->
                        <h4> KEY SUBMISSION SECTION</h4>
                        <p class="card-description">
                        Upload a photo as proof of your key return to the warden's office or guard station, and select the return date.
                        </p>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Return Key Date:</label>
                          <div class="col-sm-9">
                            <input type="date" class="form-control" name="return_key" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label  class="col-sm-3 col-form-label">Upload Proof of Key Return (image):</label>
                          <div class="col-sm-9">
                            <div class="custom-file">
                              <input type="file" name="imageFile" accept=".jpg,.jpeg,.png"  class="custom-file-input"  required>
                              <label class="custom-file-label"  for="inputGroupFile02">Choose file</label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row justify-content-end">
                          <button type="submit" class="btn btn-succces mr-3">Submit</button>
                          <button class="btn btn-danger mr-3" id="cancelButton">Cancel</button>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
      
      // Update the label text to show the selected file name for the image upload
  document.querySelector('input[name="imageFile"]').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;  // Get the selected file name
    var nextSibling = e.target.nextElementSibling; // The label element
    nextSibling.innerText = fileName; // Set the file name as the label text
  });
   
    document.getElementById('cancelButton').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default action of the button

        Swal.fire({
            title: "Are you sure?",
            text: "Any unsaved changes will be lost.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, cancel",
            cancelButtonText: "No, keep editing",
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'home.php';  // Redirect to the desired page
            }
        });
    });
</script>


  </body>
</html>