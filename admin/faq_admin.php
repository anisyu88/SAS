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
                  <span class="title">Managed Student</span>
                </a>
              </li>
               <li class="nav-item dropdown">
                 <a href="faq_admin.php" class="dropdown-toggle"  >
                   <span class="icon-holder">
                     <i class="lni-bulb"></i>
                   </span>
                   <span class="title">Frequently Ask Question</span>
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
                                <h4 class="page-title">FAQ</h4>
                            </div>
                        </div>
                        <!-- Breadcrumb End -->
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <!-- Page content here -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">Siswi Accommodation System FAQ</h4>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted m-b-30 font-14">Admin FAQ/User Manual.</p>
                                            <div id="accordion">
                                                <div class="card">
                                                     <div class="card-header" id="headingOne">
                                                        <h5 class="m-0">
                                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="text-dark collapsed">
                                                                Q1: How do I review pending applications?
                                                            </a>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                        <div class="card-body">
                                                            A1: Go to the <strong>Apply Pending</strong> page. You can view each application by clicking on it. Applications can be <strong> approved </strong> or <strong> rejected</strong> directly from this page.                                       
                                                            <br>
                                                            <img src="assets/img/usermanual/approve .png" style="width:auto ; height: 250px;">
                                                        </div>
                                                    </div>
                                                </div>
                                              <div class="card">
                                                <div class="card-header" id="headingTwo">
                                                    <h5 class="m-0">
                                                        <a class="collapsed text-dark" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                            Q2: Is there a way to prioritize applications by date or student name?
                                                        </a>
                                                    </h5>
                                                </div>
                                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                                    <div class="card-body">
                                                        A2: Use the sorting options to order applications by submission date or student name to prioritize reviews. 
                                                        <br>
                                                            <img src="assets/img/usermanual/sorting.png" style="width: 700px; height: 70px;">                                           
                                                    </div>
                                                </div>
                                              </div>
                                                <div class="card">
                                                    <div class="card-header" id="headingThree">
                                                        <h5 class="m-0">
                                                        <a class="collapsed text-dark" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                            Q3: How can I view room occupancy and availability?
                                                        </a>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                                        <div class="card-body">
                                                            A3: The Room List page shows the current occupancy of each room and its availability status.
                                                             Rooms can be set as available, booked, or under maintenance as needed.                                           
                                                             <br>
                                                             <img src="assets/img/usermanual/edit rooms status.png" style="width: 860px; height: 150px;">
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" id="headingFour">
                                                        <h5 class="m-0">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour" class="text-dark collapsed">
                                                            Q4: How do I change the status of a room?
                                                        </a>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                                        <div class="card-body">
                                                            A4: Select the room on the Edit Room page, then update the status (available/booked/under maintenance). Be sure to save any changes.
                                                            <br>
                                                            <img src="assets/img/usermanual/roomdetails.png" style="width:auto ; height: 250px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" id="headingFive">
                                                        <h5 class="m-0">
                                                        <a class="collapsed text-dark" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                            Q5:How can I generate reports for applications, bookings, and check-outs?
                                                        </a>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                                                        <div class="card-body">
                                                            A5:Each list page has a Generate Report button that allows you to download data for applications, registered students, check-outs, and room occupancy.
                                                            <br>
                                                            <img src="assets/img/usermanual/generate print and download.png" style="width:auto ; height: 250px;">
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
    // Example of how to dynamically set the application progress
    const applicationStatus = "Awaiting Approval"; // Replace this with dynamic data from the server

    const steps = document.querySelectorAll('.step');

    steps.forEach((step) => {
        if (step.textContent === applicationStatus) {
            step.classList.add('completed'); // Mark current step as completed
            return; // Stop here as we don't want to mark further steps
        }
        if (step.classList.contains('completed')) {
            step.classList.add('completed'); // Keep previous steps marked as completed
        }
    });
</script>

</body>
</html>
