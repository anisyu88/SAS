<?php
session_start();


include("../db.php");

// Query to get the number of pending, checkout, registered, and total students
$total_applications_query = "SELECT COUNT(*) AS total FROM fyp_db.apply";
$registered_query = "SELECT COUNT(*) AS total FROM fyp_db.booking";
$current_occupancy_query = "SELECT SUM(current_occupancy) AS total FROM fyp_db.room";
$pending_query = "SELECT COUNT(*) AS total FROM fyp_db.apply WHERE status = 'pending'";

// Fetch counts from database
$total_applications_count = mysqli_fetch_assoc(mysqli_query($con, $total_applications_query))['total'];
$registered_count = mysqli_fetch_assoc(mysqli_query($con, $registered_query))['total'];
$current_occupancy_count = mysqli_fetch_assoc(mysqli_query($con, $current_occupancy_query))['total'];
$pending_count = mysqli_fetch_assoc(mysqli_query($con, $pending_query))['total'];



$occupancy_query = "SELECT floor, room, current_occupancy FROM fyp_db.room ORDER BY room ASC";
$occupancy_result = mysqli_query($con, $occupancy_query);

$floor_data = [];
while ($row = mysqli_fetch_assoc($occupancy_result)) {
    $floor = $row['floor'];
    $room = $row['room'];
    $occupancy = $row['current_occupancy'];

    if (!isset($floor_data[$floor])) {
        $floor_data[$floor] = [];
    }
    $floor_data[$floor][$room] = $occupancy;
}

$floor_data_json = json_encode($floor_data);



// Graph 2: Semester-Based Student Distribution (Horizontal Scale Bar)
$semester_query = "SELECT sem, COUNT(*) AS student_count FROM fyp_db.apply GROUP BY sem";
$semester_result = mysqli_query($con, $semester_query);
$semesters = [];
$semester_student_counts = [];
while($row = mysqli_fetch_assoc($semester_result)) {
    $semesters[] = 'Semester ' . $row['sem'];
    $semester_student_counts[] = $row['student_count'];
}
$semesters_json = json_encode($semesters);
$semester_student_counts_json = json_encode($semester_student_counts);

// Graph 3: Room Status Overview
$status_query = "SELECT status, COUNT(*) AS status_count FROM fyp_db.room GROUP BY status";
$status_result = mysqli_query($con, $status_query);
$statuses = [];
$status_counts = [];
while($row = mysqli_fetch_assoc($status_result)) {
    $statuses[] = $row['status'];
    $status_counts[] = $row['status_count'];
}
$statuses_json = json_encode($statuses);
$status_counts_json = json_encode($status_counts);

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
                    <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
                <!-- Breadcrumb End -->
                </div>

                <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-xs-12">
                                <div class="info-box bg-primary">
                                    <div class="icon-box">
                                        <i class="lni-archive"></i>
                                    </div>
                                    <div class="info-box-content">
                                        <h4 class="number"><?php echo $total_applications_count; ?></h4>
                                            <p class="info-text">Total Application</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-xs-12">
                                <div class="info-box bg-success">
                                    <div class="icon-box">
                                        <i class="lni-users"></i>
                                    </div>
                                    <div class="info-box-content">
                                        <h4 class="number"><?php echo $registered_count; ?></h4>
                                            <p class="info-text">Total Registration</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-xs-12">
                                <div class="info-box bg-info">
                                    <div class="icon-box">
                                        <i class="lni-home"></i>
                                    </div>
                                    <div class="info-box-content">
                                        <h4 class="number"><?php echo $current_occupancy_count; ?></h4>
                                            <p class="info-text">Current Occupancy</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-xs-12">
                                <div class="info-box bg-purple">
                                    <div class="icon-box">
                                        <i class="lni-hourglass"></i>
                                    </div>
                                    <div class="info-box-content">
                                        <h4 class="number"><?php echo $pending_count; ?></h4>
                                            <p class="info-text">Total Pending Application</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- graph 1 -->
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="card">
                          <div class="card-header border-bottom">
                            <!-- Graph 1: Room Occupancy Chart (Horizontal Bar Chart) -->
                            <h4 class="card-title">Room Occupancy Chart</h4>
                          </div>
                          <div class="card-body">
                            <div id="morris-bar-example" style="height: auto; width: auto;">
                              <canvas id="roomOccupancyChart"></canvas>
                            </div>
                          </div>
                        </div>
                      </div> 
                    </div>
                    <!-- graph 2&3 -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                  <!-- Graph 2: Semester-Based Student Distribution (Horizontal Bar Chart) -->
                                <h5 class="card-title">Application to Residence Semester-Based Student</h5>
                                
                                </div>
                                <div class="card-body">
                                <div id="morris-bar-example" style="height: 372px">
                                  <canvas id="semesterStudentChart" ></canvas>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body text-center">
                                          <!-- Graph 3: Room Status Overview (Donut Chart) -->
                                            <h4 class="header-title">Room Status Overview </h4>
                                            
                                            <div id="morris-donut-example" style="height: 400px">
                                              <canvas id="roomStatusChart"></canvas>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
   // Log the data structure to debug
   const floorData = <?php echo $floor_data_json; ?>;
   console.log(floorData);

const sortedRooms = Object.keys(floorData)
    .flatMap((floor) => Object.keys(floorData[floor]))
    .sort((a, b) => a.localeCompare(b)); // Sort alphabetically or numerically

const datasets = sortedRooms.map((room) => {
    const data = Object.keys(floorData).map((floor) => floorData[floor][room] || 0);
    return {
        label: room,
        data: data,
        backgroundColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.7)`,
    };
});

const ctx2 = document.getElementById('roomOccupancyChart').getContext('2d');
const roomOccupancyChart = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: Object.keys(floorData), // Floors as labels
        datasets: datasets,
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false, // Disable the legend
            },
        },
        scales: {
            x: {
                stacked: true, // Stack the bar chart
            },
            y: {
                stacked: true,
                title: {
                    display: true,
                    text: 'Occupancy', // Label for Y-axis
                },
            },
        },
    },
});





    // Graph 2: Semester-Based Student Distribution (Horizontal Bar Chart)
    const semesters = <?php echo $semesters_json; ?>;
    const semesterStudentCounts = <?php echo $semester_student_counts_json; ?>;
    const ctx3 = document.getElementById('semesterStudentChart').getContext('2d');
    const semesterStudentChart = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: semesters,
            datasets: [{
                label: 'Number of Students',
                data: semesterStudentCounts,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',  // Horizontal bar chart
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });
    // Graph 3: Room Status Overview (Donut Chart)
    const statuses = <?php echo $statuses_json; ?>;
    const statusCounts = <?php echo $status_counts_json; ?>;
    const ctx1 = document.getElementById('roomStatusChart').getContext('2d');
    const roomStatusChart = new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: statuses,
            datasets: [{
                data: statusCounts,
                backgroundColor: ['#36a2eb', '#ff6384', '#ffcd56']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
</script>


  </body>
</html>