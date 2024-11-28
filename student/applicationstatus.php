<?php
session_start();
include('../db.php');

if (!isset($_SESSION['studid'])) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Student ID not found. Please log in to check your application status.',
            icon: 'error',
        }).then(() => {
            window.location.href = 'login.php';
        });
    </script>";
    exit;
}
// Assuming student's ID is stored in the session
$studid = $_SESSION['studid'];

// Query to retrieve the student's application based on their ID
$query = "SELECT applyid, studid, status FROM apply WHERE studid = ? ORDER BY applyid DESC";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $studid);
$stmt->execute();
$result = $stmt->get_result();


// Handle room booking
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['booking'])) {
    $room_id = filter_var($_POST['room'], FILTER_SANITIZE_NUMBER_INT); // Sanitize room_id
    $booking_date = filter_var($_POST['booking_date'], FILTER_SANITIZE_STRING); // Sanitize booking_date

    // Check room status and availability from room table
    $roomQuery = "SELECT current_occupancy, capacity, status FROM room WHERE room_id = ?";
    $stmtRoom = $con->prepare($roomQuery);
    $stmtRoom->bind_param("i", $room_id);
    $stmtRoom->execute();
    $resultRoom = $stmtRoom->get_result();

    if ($resultRoom->num_rows > 0) {
        $roomData = $resultRoom->fetch_assoc();
        $currentOccupancy = $roomData['current_occupancy'];
        $capacity = $roomData['capacity'];
        $status = $roomData['status'];

        if ($status == 'maintenance' || $status == 'booked') {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Room Unavailable',
                        text: 'The selected room is currently unavailable. Please choose another room.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                });
            </script>";
        } else {
            // Proceed with booking if room is available and status is not 'maintenance' or 'booked'
            $stmtBooking = $con->prepare("INSERT INTO booking (studid, room_id, booking_date) VALUES (?, ?, ?)");
            $stmtBooking->bind_param("sis", $studid, $room_id, $booking_date);

            if ($stmtBooking->execute()) {
                // Update room occupancy
                $newOccupancy = $currentOccupancy + 1;
                $updateRoom = $con->prepare("UPDATE room SET current_occupancy = ? WHERE room_id = ?");
                $updateRoom->bind_param("ii", $newOccupancy, $room_id);
                $updateRoom->execute();

                // Retrieve student's name for PDF generation
                $studentQuery = "SELECT studname FROM apply WHERE studid = ?";
                $stmtName = $con->prepare($studentQuery);
                $stmtName->bind_param("s", $studid);
                $stmtName->execute();
                $resultName = $stmtName->get_result();

                if ($resultName->num_rows > 0) {
                    $row = $resultName->fetch_assoc();
                    $studname = $row['studname'];

                    // Call the function to generate PDF after booking
                    generatePDF($studid, $studname, $room_id, $booking_date);

                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function () {
                            Swal.fire({
                                title: 'Booking Successful!',
                                text: 'Your room has been booked successfully.',
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'Download PDF',
                                cancelButtonText: 'Go to Profile'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Open the PDF in a new tab
                                    window.open('booking_invoice/{$studid}_booking.pdf', '_blank');
                                    // Optionally, trigger a direct download in some cases
                                    var link = document.createElement('a');
                                    link.href = 'booking_invoice/{$studid}_booking.pdf';
                                    link.download = '{$studid}_booking.pdf'; // Specify the file name
                                    link.click();
                                } else {
                                    window.location.href = 'profile.php';
                                }
                            });
                        });
                    </script>";

                } else {
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                    echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Student name not found.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    </script>";
                }
            } else {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to book the room.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                </script>";
            }
        }
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Room not found.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
    }
}

function generatePDF($studid, $studname, $room_id, $booking_date) {
    require_once('../TCPDF-main/tcpdf.php');  // Ensure TCPDF is included

    // Create a new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator('Siswi Accommodation System');
    $pdf->SetAuthor('UPTM');
    $pdf->SetTitle('Room Booking Confirmation');
    
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Confirmation of Room Booking', 'Generated by Siswi Accommodation System');
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
    //set 
    $pdf->AddPage('P', 'A4');
    //set content
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->Cell(0, 15, 'Room Booking Confirmation,UPTM', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Official Booking Document', 0, 1, 'C');
    $pdf->Ln(10);
    $tbl = '
    <table cellspacing="0" cellpadding="6" border="1">
        <tr><th>Student ID</th><td>' . $studid . '</td></tr>
        <tr><th>Full Name</th><td>' . $studname . '</td></tr>
        <tr><th>Room Number</th><td>' . $room_id . '</td></tr>
        <tr><th>Booking Date</th><td>' . $booking_date . '</td></tr>
    </table>';
    $pdf->writeHTML($tbl, true, false, false, false, '');
    $pdf->Output(__DIR__ . '/booking_invoice/' . $studid . '_booking.pdf', 'F');
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
    
</head>

<body>
    <div class="app header-default side-nav-light ">
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
                                    <i class="lni-dashboard"></i>
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
                                <h4 class="page-title">Table</h4>
                            </div>
                            
                        </div>
                        <!-- Breadcrumb End -->
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">APPLICATION STATUS</h4>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        if ($result && $result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $status = $row['status'];
                                                if ($status == 'pending') {
                                                    echo "<p class='text-center text-warning'>YOUR APPLICATION IS PENDING</p>";
                                                } elseif ($status == 'Approved') {
                                                    echo "<p class='text-center text-success'>YOUR APPLICATION HAS BEEN APPROVED</p>";
                                                    ?>
                                                    <form class="forms-sample" method="POST" action="">
                                                        <div class="form-group row">
                                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Apply ID:</label>
                                                            <div class="col-sm-9">
                                                                <?php echo $row['applyid']; ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Student ID</label>
                                                            <div class="col-sm-9">
                                                                <?php echo htmlspecialchars($_SESSION['studid']); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Choose Floor:</label>
                                                            <div class="col-sm-9">
                                                                <select name="floor" class="form-control" id="floor" onchange="updateRooms()" required>
                                                                    <option value="">--Select floor--</option>
                                                                    <option value="1">Floor 1</option>
                                                                    <option value="2">Floor 2</option>
                                                                    <option value="3">Floor 3</option>
                                                                    <option value="4">Floor 4</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Book House:</label>
                                                            <div class="col-sm-9">
                                                                <select name="room" class="form-control" id="room" required>
                                                                    <!-- Rooms will be updated dynamically based on selected floor -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Booking Date:</label>
                                                            <div class="col-sm-9">
                                                                <input type="date" class="form-control" name="booking_date" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row justify-content-end">
                                                            <button type="submit" name="booking" class="btn btn-light mr-3">Submit</button>
                                                            <button type="button" id="cancelButton" class="btn btn-danger mr-3">Cancel</button>
                                                        </div>
                                                    </form>
                                                    <script>
                                                        function updateRooms() {
                                                            var floor = document.getElementById('floor').value;
                                                            var roomSelect = document.getElementById('room');
                                                            roomSelect.innerHTML = ""; // Clear previous options

                                                            if (floor == "1") {
                                                                roomSelect.innerHTML = 
                                                                    '<option value="6001">11-1-1</option>' +
                                                                    '<option value="6002">11-1-2</option>' +
                                                                    '<option value="6003">11-1-3</option>' +
                                                                    '<option value="6004">11-1-4</option>' +
                                                                    '<option value="6005">11-1-5</option>' +
                                                                    '<option value="6006">11-1-6</option>' +
                                                                    '<option value="6007">11-1-7</option>' +
                                                                    '<option value="6008">11-1-8</option>' +
                                                                    '<option value="6009">11-1-9</option>' +
                                                                    '<option value="6010">11-1-10</option>' +
                                                                    '<option value="6011">11-1-11</option>' +
                                                                    '<option value="6012">11-1-12</option>' +
                                                                    '<option value="6013">11-1-13</option>' +
                                                                    '<option value="6014">11-1-14</option>';
                                                            } else if (floor == "2") {
                                                                roomSelect.innerHTML = 
                                                                    '<option value="7001">11-2-1</option>' +
                                                                    '<option value="7002">11-2-2</option>' +
                                                                    '<option value="7003">11-2-3</option>' +
                                                                    '<option value="7004">11-2-4</option>' +
                                                                    '<option value="7005">11-2-5</option>' +
                                                                    '<option value="7006">11-2-6</option>' +
                                                                    '<option value="7007">11-2-7</option>' +
                                                                    '<option value="7008">11-2-8</option>' +
                                                                    '<option value="7009">11-2-9</option>' +
                                                                    '<option value="7010">11-2-10</option>' +
                                                                    '<option value="7011">11-2-11</option>' +
                                                                    '<option value="7012">11-2-12</option>' +
                                                                    '<option value="7013">11-2-13</option>' +
                                                                    '<option value="7014">11-2-14</option>';
                                                            } else if (floor == "3") {
                                                                roomSelect.innerHTML = 
                                                                    '<option value="8001">11-3-1</option>' +
                                                                    '<option value="8002">11-3-2</option>' +
                                                                    '<option value="8003">11-3-3</option>' +
                                                                    '<option value="8004">11-3-4</option>' +
                                                                    '<option value="8005">11-3-5</option>' +
                                                                    '<option value="8006">11-3-6</option>' +
                                                                    '<option value="8007">11-3-7</option>' +
                                                                    '<option value="8008">11-3-8</option>' +
                                                                    '<option value="8009">11-3-9</option>' +
                                                                    '<option value="8010">11-3-10</option>' +
                                                                    '<option value="8011">11-3-11</option>' +
                                                                    '<option value="8012">11-3-12</option>' +
                                                                    '<option value="8013">11-3-13</option>' +
                                                                    '<option value="8014">11-3-14</option>';
                                                            } else if (floor == "4") {
                                                                roomSelect.innerHTML = 
                                                                    '<option value="9001">11-4-1</option>' +
                                                                    '<option value="9002">11-4-2</option>' +
                                                                    '<option value="9003">11-4-3</option>' +
                                                                    '<option value="9004">11-4-4</option>' +
                                                                    '<option value="9005">11-4-5</option>' +
                                                                    '<option value="9006">11-4-6</option>' +
                                                                    '<option value="9007">11-4-7</option>' +
                                                                    '<option value="9008">11-4-8</option>' +
                                                                    '<option value="9009">11-4-9</option>' +
                                                                    '<option value="9010">11-4-10</option>' +
                                                                    '<option value="9011">11-4-11</option>' +
                                                                    '<option value="9012">11-4-12</option>' +
                                                                    '<option value="9013">11-4-13</option>' +
                                                                    '<option value="9014">11-4-14</option>';
                                                            }
                                                        }

                                                        document.getElementById('cancelButton').addEventListener('click', function(e) {
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
                                                    </script>
                                                    <?php
                                                } elseif ($status == 'Reject') {
                                                    echo "<p class='text-center text-danger'>YOUR APPLICATION HAS BEEN REJECTED</p>";
                                                }
                                            }
                                        } else {
                                            echo "<p class='text-center text-info'>NO APPLICATIONS FOUND.</p>";
                                        }
                                        ?>
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
                            <span>Copyright © 2024 <b class="text-dark">Siswi Accommodation System</b>. All Rights Reserved</span>
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
</body>
</html>
