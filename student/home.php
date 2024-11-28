<?php
session_start();
include('../db.php');

// Check if the student is logged in
if (!isset($_SESSION['studid'])) {
    // If not logged in, include SweetAlert and show the error message
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Error',
            text: 'Student ID not found. Please log in.',
            icon: 'error',
        }).then(function() {
            window.location.href = 'login.php';
        });
    });
</script>";
exit;


} 

// If logged in, retrieve the student ID from the session
$studid = $_SESSION['studid'];

//active
$current_page = basename($_SERVER['PHP_SELF']);
// Prepare the SQL query to join student and apply tables
$student_query = "
    SELECT 
        student.studid, 
        student.studname, 
        student.mail, 
        student.program, 
        student.sem, 
        apply.status 
    FROM student 
    LEFT JOIN apply ON student.studid = apply.studid
    WHERE student.studid = ?
";

// Prepare the statement
$stmt = $con->prepare($student_query);
$stmt->bind_param("s", $studid);  // Bind the student ID

// Execute the query
if ($stmt->execute()) {
    $student_result = $stmt->get_result();
    
    if ($student_result->num_rows > 0) {
        // Fetch the student data
        $student = $student_result->fetch_assoc();
        $studname = htmlspecialchars($student['studname']);
        $mail = htmlspecialchars($student['mail']);
        $program = htmlspecialchars($student['program']);
        $sem = htmlspecialchars($student['sem']);
        $status = htmlspecialchars($student['status']); // Fetching application status
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Student information not found.',
                    icon: 'error',
                });
              </script>";
        exit;
    }
} else {
    echo "Error executing query: " . $stmt->error;
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SAS - STUDENT</title>
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
<style>
    * {box-sizing: border-box}
.mySlides1, .mySlides2 {display: none}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}
    /* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -22px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}
/* On hover, add a grey background color */
.prev:hover, .next:hover {
  background-color: #f1f1f1;
  color: black;
}
</style>
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
                            <div class="col-2 col-lg-3 col-md-6">
                                <h4 class="page-title">Home</h4>
                            </div>
                        </div>
                        <!-- Breadcrumb End -->
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <!-- Page content here -->
                            <div class="col-md-8">
                                <div class="card">
                                <div class="card-header">
                                    <div class="card-header border-bottom">
                                    <h4 class="card-title"> WELCOME</h4>
                                    </div>
                                    <div class="card-body">
                                    <form class="forms-sample">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">STUDENT ID: </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="studid" class="form-control" value="<?php echo $studid; ?>" readonly>
                                                </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Student Name:</label>
                                                <div class="col-sm-9">
                                                <input type="text" name="studname" class="form-control" value="<?php echo $studname; ?>" readonly>
                                                </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputMobile" class="col-sm-3 col-form-label">Email: </label>
                                                <div class="col-sm-9">
                                                <input type="text" name="mail" class="form-control" value="<?php echo $mail; ?>" readonly>
                                                </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Semester:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="<?php echo $sem; ?>" readonly>
                                                </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Application For Accommodation Status:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="<?php echo $status; ?>" readonly>
                                                </div>
                                        </div>
                                        
                                        <div class="text-right">
                                            <a href="profile.php" class="btn btn-outline-primary" >EDIT PROFILE</a> <!-- Print button -->
                                        
                                    </div>
                                    </form>

                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                <div class="col-12 stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="sales-info">
                                                <h3>Facilities in Siswi</h3>
                                            </div>
                                            <div class="slideshow-container">
                                                <div class="mySlides1">
                                                  <img src="assets/img/faci1.jpg" style="width:100%">
                                                </div>
                                              
                                                <div class="mySlides1">
                                                  <img src="assets/img/faci2.jpg" style="width:100%">
                                                </div>
                                              
                                                <div class="mySlides1">
                                                  <img src="assets/img/faci3.jpg" style="width:100%">
                                                </div>
                                            <!-- Controls for navigating the slideshow -->
                                            <a class="prev" onclick="plusSlides(-1, 0)">&#10094;</a>
                                            <a class="next" onclick="plusSlides(1, 0)">&#10095;</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="sales-info">
                                                <h3 class="text-center">Warden Information</h3>
                                            </div>
                                            <div class="warden-info">
                                                <div class="row mb-2">
                                                    <div class="col-4">
                                                        <strong>Name:</strong>
                                                    </div>
                                                    <div class="col-8">
                                                        PUAN ASYIKIN OTHMAN
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-4">
                                                        <strong>Contact Number:</strong>
                                                    </div>
                                                    <div class="col-8">
                                                        01137072835
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <strong>Room Number:</strong>
                                                    </div>
                                                    <div class="col-8">
                                                        11-G-1
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
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
                            <span>Copyright © 2024 <b class="text-dark">Siswi Accommodation System</b>. All Right Reserved</span>
                            <span class="go-right">
                                <a href="" class="text-gray">Term & Conditions</a>
                                <a href="" class="text-gray">Privacy & Policy</a>
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
        let slideIndex = [1,1];
        let slideId = ["mySlides1", "mySlides2"]
        showSlides(1, 0);
        showSlides(1, 1);
        
        function plusSlides(n, no) {
          showSlides(slideIndex[no] += n, no);
        }
        
        function showSlides(n, no) {
          let i;
          let x = document.getElementsByClassName(slideId[no]);
          if (n > x.length) {slideIndex[no] = 1}    
          if (n < 1) {slideIndex[no] = x.length}
          for (i = 0; i < x.length; i++) {
             x[i].style.display = "none";  
          }
          x[slideIndex[no]-1].style.display = "block";  
        }
        </script>

</body>
</html>

