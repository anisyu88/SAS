<?php
include('../db.php');

// Check if the student ID is set in the URL
if (isset($_GET['studid'])) {
    $studid = $_GET['studid'];

    // Fetch student details from the database
    $query = "SELECT * FROM student WHERE studid = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $studid);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    // Check if the form is submitted to update student data
    if (isset($_POST['update'])) {
        // Sanitize and fetch new/edited values from the form
        $studname = filter_var($_POST['studname'], FILTER_SANITIZE_STRING);
        $mail = filter_var($_POST['mail'], FILTER_SANITIZE_STRING);
        $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
        $program = filter_var($_POST['program'], FILTER_SANITIZE_STRING);
        $noic = filter_var($_POST['noic'], FILTER_SANITIZE_STRING);
        $nophone = filter_var($_POST['nophone'], FILTER_SANITIZE_STRING);
        $sem = filter_var($_POST['sem'], FILTER_SANITIZE_NUMBER_INT);
        $sponsorship = filter_var($_POST['sponsorship'], FILTER_SANITIZE_STRING);
        $parentsno = filter_var($_POST['parentsno'], FILTER_SANITIZE_STRING);
        $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
        
        // Prepare the UPDATE SQL statement to update the student's information
    $update_query = "UPDATE student SET studname = ?, mail=?, pass=?, program = ?, noic = ?, nophone = ?, sem = ?, sponsorship=?, parentsno=? WHERE studid = ?";
    $update_stmt = $con->prepare($update_query);
    $update_stmt->bind_param("ssssssisss", $studname, $mail, $pass ,$program, $noic, $nophone, $sem, $sponsorship, $parentsno, $studid);

        // Execute the statement and check for success
        if ($update_stmt->execute()) {
            // SweetAlert2 success notification
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Data has been successfully updated.',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = 'registered.php';
                    });
                });
                </script>";
        } else {
            // SweetAlert2 error notification
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    title: 'Failed!',
                    text: 'Failed to update student details.',
                    icon: 'error'
                });
                </script>";
        }
    }
} else {
    // Redirect if no student is selected
    echo "<script>
        alert('No student selected.');
        window.location.href='registered.php';
        </script>";
    exit;
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
                  <h4 class="page-title">Student Information</h4>
                </div>
                <div class="col-12 col-lg-9 col-md-6">
                  <ol class="breadcrumb float-right">
                    <li><a href="#">Student</a></li>
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
                      <h4 class="card-title">Student Details</h4>
                    </div>
                    <div class="card-body">
                      
                      <form class="forms-sample" method="POST">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Full Name:</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="studname" value="<?php echo htmlspecialchars($student['studname']); ?>" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Student ID:</label>
                          <div class="col-sm-9">
                            <input type="text" name="studid" class="form-control" value="<?php echo htmlspecialchars($student['studid']); ?>" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Email: </label>
                          <div class="col-sm-9">
                            <input type="text" name="mail" class="form-control" value="<?php echo htmlspecialchars($student['mail']); ?>" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Password:</label>
                          <div class="col-sm-9">
                            <input type="text" name="pass" class="form-control" value="<?php echo htmlspecialchars($student['pass']); ?>" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label  class="col-sm-3 col-form-label"> Program: </label>
                          <div class="col-sm-9">
                          <select name="program" class="form-control" required>
                              <option value="ACCA" <?php echo $student['program'] == 'ACCA' ? 'selected' : ''; ?>>Association of Chartered Certified Accountants (ACCA) Professional Qualification</option>
                              <option value="AA103" <?php echo $student['program'] == 'AA103' ? 'selected' : ''; ?>>Diploma of Accountancy (AA103)</option>
                              <option value="CC101" <?php echo $student['program'] == 'CC101' ? 'selected' : ''; ?>>Diploma in Computer Science (CC101)</option>
                              <option value="BK101" <?php echo $student['program'] == 'BK101' ? 'selected' : ''; ?>>Diploma in Corporate Communication (BK101)</option>
                              <option value="AA201" <?php echo $student['program'] == 'AA201' ? 'selected' : ''; ?>>Bachelor of Accountancy (Honours) (AA201)</option>
                              <option value="BE201" <?php echo $student['program'] == 'BE201' ? 'selected' : ''; ?>>Bachelor of Arts (Hons) in Applied English Language Studies (BE201)</option>
                              <option value="BE202" <?php echo $student['program'] == 'BE202' ? 'selected' : ''; ?>>Bachelor of Early Childhood Education (BE202)</option>
                              <option value="BE203" <?php echo $student['program'] == 'BE203' ? 'selected' : ''; ?>>Bachelor of Education (Honours) in Teaching English As A Second Language (TESL) (BE203)</option>
                              <option value="CM201" <?php echo $student['program'] == 'CM201' ? 'selected' : ''; ?>>Bachelor of Arts in 3D Animation and Digital Media (CM201)</option>
                              <option value="AB201" <?php echo $student['program'] == 'AB201' ? 'selected' : ''; ?>>Bachelor of Business Administration Human Resource Management (AB201)</option>
                              <option value="AC201" <?php echo $student['program'] == 'AC201' ? 'selected' : ''; ?>>Bachelor of Corporate Administration(AC201)</option>
                              <option value="AB202" <?php echo $student['program'] == 'AB202' ? 'selected' : ''; ?>>Bachelor of Business Administration (AB202)</option>
                              <option value="BK201" <?php echo $student['program'] == 'BK201' ? 'selected' : ''; ?>>Bachelor of Communication (Hons) in Corporate Communication (BK201)</option>
                              <option value="CT203" <?php echo $student['program'] == 'CT203' ? 'selected' : ''; ?>>Bachelor of Information Technology in Business Computing (CT203)</option>
                              <option value="CT204" <?php echo $student['program'] == 'CT204' ? 'selected' : ''; ?>>Bachelor of Information Technology (Honours) in Computer Application Development (CT204)</option>
                              <option value="CT206" <?php echo $student['program'] == 'CT206' ? 'selected' : ''; ?>>Bachelor of Information Technology (Honours) in Cyber Security (CT206)</option>
                          </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Identity Card Number:</label>
                          <div class="col-sm-9">
                            <input type="text" name="noic" class="form-control" value="<?php echo htmlspecialchars($student['noic']); ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="12" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Semester:</label>
                          <div class="col-sm-9">
                            <input type="number" class="form-control" name="sem" value="<?php echo htmlspecialchars($student['sem']); ?>" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Telephone Number:</label>
                          <div class="col-sm-9">
                            <input type="text" name="nophone" class="form-control" value="<?php echo htmlspecialchars($student['nophone']); ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="12" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label  class="col-sm-3 col-form-label">Status:</label>
                          <div class="col-sm-9">
                            <input type="text" name="status" class="form-control" value="<?php echo htmlspecialchars($student['status']); ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label"> Sponsorship </label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="sponsorship" value="<?php echo htmlspecialchars($student['sponsorship']); ?>" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label  class="col-sm-3 col-form-label"> Parent's Phone Number: </label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="parentsno" value="<?php echo htmlspecialchars($student['parentsno']); ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="12" required>
                          </div>
                        </div>
                        <div class="form-group row justify-content-end">
                          <button type="submit" name="update" class="btn btn-success mr-3">Save Changes</button>
                        <a href="view_student.php" id="cancelButton" class="btn btn-danger">Cancel</a>
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
                window.location.href = 'view_student.php';  // Redirect to profile or appropriate page
            }
        });
    });
</script>


  </body>
</html>