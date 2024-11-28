<?php
session_start();
// Start output buffering
ob_start();


include('../db.php');

// Check if the student is logged in
if (!isset($_SESSION['studid'])) {
  // If not logged in, include SweetAlert and show the error message
  echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";
  echo "<script>
      swal({
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

//active
$current_page = basename($_SERVER['PHP_SELF']);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$pdf_output = '';  // Initialize the variable for the PDF file path

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $studname = filter_var($_POST['studname'], FILTER_SANITIZE_STRING);
    $sem = filter_var($_POST['sem'], FILTER_SANITIZE_NUMBER_INT);
    $apply_date = filter_var($_POST['apply_date'], FILTER_SANITIZE_STRING); 
    $studid = $_SESSION['studid'];  

    // Handle file upload logic
    if (isset($_FILES['pdfFile']) && $_FILES['pdfFile']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "apply/";
        $file_name = uniqid() . "_" . basename($_FILES["pdfFile"]["name"]); // Unique file name to prevent overwriting
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($file_type != "pdf") {
            echo "<script>alert('Only PDF files are allowed.');</script>";
        } else {
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $target_file)) {
                $stmt = $con->prepare("INSERT INTO apply (studid, studname, sem, apply_date, filename, filepath, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
                $stmt->bind_param("ssisss", $studid, $studname, $sem, $apply_date, $file_name, $target_file);

                if ($stmt->execute()) {
                    // Call the function to generate PDF
                    generatePDF($studid, $studname, $sem, $apply_date, $file_name);
                    //echo "<script>alert('Successful Registration. YOUR APPLICATION IS UNDER PROCESS');</script>";

                    // Redirect to success page
                    //header("Location: success.php");
                    // SweetAlert success notification
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js'></script>";
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Your application has been submitted successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(function() {
                                // Redirect to succes_apply.php after the SweetAlert is closed
                                window.location.href = 'success_apply.php?status=success';
                            });
                        });
                    </script>";

                    exit();
                } else {
                    //echo "<script>alert('Failed to register the application. SQL Error: " . $stmt->error . "');</script>";
                    echo "<script>
                    alert('Failed to register the application. SQL Error: " . $stmt->error . "');
                    </script>";
                }
            } else {
                
                 // SweetAlert error notification
                echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";
                echo "<script>
                    swal({
                        title: 'Failed',
                        text: 'There was an error uploading the file.',
                        icon: 'error',
                    });
                    </script>";
                }
        }
    } else {
       // echo "<script>alert('No file was uploaded or there was an error with the file upload.');</script>";
         // SweetAlert error notification
         echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";
         echo "<script>
             swal({
                 title: 'Failed',
                 text: 'No file was uploaded or there was an error with the file upload',
                 icon: 'info',
             });
             </script>";
    }
}
// End output buffering and flush output
ob_end_flush();

function generatePDF($studid, $studname, $sem, $apply_date, $file_name) {
    require_once('../TCPDF-main/tcpdf.php');  // Ensure TCPDF is included
 
    // Create a new PDF document
 $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator('Siswi Accommodation System');
    $pdf->SetAuthor('UPTM');
    $pdf->SetTitle('Application to Desa Siwi');
    $pdf->SetSubject('Application to Desa Siwi');
    $pdf->SetKeywords('Desa Siswi, Application, PDF');


    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Application to Desa Siwi', 'Generated by Siswi Accommodation System');
    // Set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // Set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // Set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // Set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // Add a page
    $pdf->AddPage('P', 'A4');

    // Set content font
    $pdf->SetFont('helvetica', '', 12);
   

    // Title
    $pdf->SetFont('helvetica', 'B', 16);  // Bold title font
    $pdf->Cell(0, 15, 'Application to Desa Siwi', 0, 1, 'C');
    $pdf->Ln(8);  // Line break

    // Organization details
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, 'Siswi Accommodation Office, UPTM', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Official Booking Document', 0, 1, 'C');
    $pdf->Ln(10);

    // Student information
    $pdf->Cell(40, 10, 'Student ID: ' . $studid);
    $pdf->Ln(10);
    $pdf->Cell(40, 10, 'Full Name: ' . $studname);
    $pdf->Ln(10);
    $pdf->Cell(40, 10, 'Semester: ' . $sem);
    $pdf->Ln(10);
    $pdf->Cell(40, 10, 'Apply Date: ' . $apply_date);
    $pdf->Ln(10);
    $pdf->Cell(40, 10, 'Uploaded File: ' . $file_name);
    $pdf->Ln(10);
    
     // Write the HTML table to the PDF
     $pdf->writeHTML(true, false, false, false, '');

     $pdf->Ln(10);  // Line break before signature
 
     // Signature area
     $pdf->Cell(0, 10, 'Signature: _____________________', 0, 1, 'L');
     $pdf->Cell(0, 10, 'Date: ' . date('d-m-Y'), 0, 1, 'R');
 
     // Footer note
     $pdf->Ln(10);
     $pdf->Cell(0, 10, '* This is a system-generated document and does not require any physical signature.', 0, 1, 'C');
 

    // Define output path
    //$output_dir = __DIR__ . '/apply_reports/';

    /* Check if the directory exists, if not, create it
    if (!file_exists($output_dir) && !is_dir($output_dir)) {
        mkdir($output_dir, 0777, true); // Create directory with permissions
    }*/

    // Save the PDF to a file
   // $pdf_output = $output_dir . $studid . '_application.pdf', 'F';
    // Output the PDF (save or download)
    $pdf->Output(__DIR__ . '/apply_invoice/' . $studid . '_application.pdf', 'F');
    
    /*if (!$pdf->Output($pdf_output, 'F')) {
        //ni tukar sweet alert
        echo "PDF generated successfully: " . $pdf_output;
        
    }else{
        echo "<script>alert('Error generating PDF.');</script>";
    }*/

}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SAS -STUDENT</title>
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
              <!-- Breadcrumb Start -->
              <div class="breadcrumb-wrapper row">
                <div class="col-12 col-lg-3 col-md-6">
                  <h4 class="page-title">Form</h4>
                </div>
                <div class="col-12 col-lg-9 col-md-6">
                  <ol class="breadcrumb float-right">
                    <li><a href="#">Apply</a></li>
                    <li class="active"> / Apply Form</li>
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
                        <h4 class="card-title">APPLY FOR ACCOMMODATION</h4>
                      </div>
                      <div class="card-body">
                        <p class="card-description">
                          Make sure to fill everything before submit 
                        </p>
                        <form class="forms-sample" method="POST" enctype="multipart/form-data" >
                          <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Student ID: </label>
                            <div class="col-sm-9">
                              <label class="form-control"> 
                                <?php echo htmlspecialchars($_SESSION['studid']); ?>
                              </label>
                            </div>
                          </div>
                          <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Student Full Name:</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="studname" placeholder="Your Full Name" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Current Semester:</label>
                          <div class="col-sm-9">
                            <input type="number" class="form-control" name="sem" placeholder="Current Semester" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Date:</label>
                          <div class="col-sm-9">
                            <input type="date" class="form-control" name="apply_date" required>
                          </div>
                        </div>
                          <div class="form-group row">
                            <label  class="col-sm-3 col-form-label">Upload</label>
                            <div class="col-sm-9">
                              <div class="custom-file">
                                <input type="file" name="pdfFile" id="pdfFile" class="custom-file-input" accept="application/pdf" placeholder="Choose File" required>
                                <label class="custom-file-label" for="pdfFile"></label>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row justify-content-end">
                            <button type="submit" class="btn btn-success mr-3">Submit</button>
                            <button class="btn btn-danger">Cancel</button>
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
    <script src='assets/js/sweetalert.min.js'></script>
    <script src="../sweetalert2/package/dist/sweetalert2.min.js"></script>
    <script>
      // This will update the file name in the label when a file is selected
      document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;  // Get the selected file name
        var nextSibling = e.target.nextElementSibling; // The label element
        nextSibling.innerText = fileName; // Set the file name as the label text
      });
    </script>
  </body>
</html>