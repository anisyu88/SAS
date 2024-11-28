<?php
session_start();

include('../db.php'); // Ensure database connection

if (!$con) {
    die("Database connection error: " . mysqli_connect_error());
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
    <!-- DataTable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
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
                  <span class="title">Managed Student</span>
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
                  <h4 class="page-title">Student List</h4>
                </div>
                <div class="col-12 col-lg-9 col-md-6">
                  <ol class="breadcrumb float-right">
                    <li><a href="#">Registered List</a></li>
                    <li class="active"> / Student List</li>
                  </ol>
                </div>
              </div>
              <!-- Breadcrumb End -->
            </div>

            <div class="container-fluid">
             
             <!-- hoveravles rows -->
              <div class="row">
                <div class="col-12 col-xl-12 m-b-10">
                  <div class="card">
                    <div class="card-header border-bottom">
                      <h4 class="card-title">View All Student </h4>
                    </div>
                    <div class="card-body">
                      
                      <div class="table-responsive">
                        <table id="myTable" class="table table-hover mb-0">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Student ID</th>
                              <th>Student Name</th>
                              <th>Password</th>
                              <th>Mail</th>
                              <th>Semester</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
                           
                      // Corrected SQL query using INNER JOIN to combine student and registered tables
                     // Corrected SQL query using '=' for comparison
                     $query = "SELECT * FROM student "; 
                    $result = mysqli_query($con, $query);
                      $result = mysqli_query($con, $query);

                      // Check if there are any rows in the result
                      if (mysqli_num_rows($result) > 0) {
                          $counter = 1; // Initialize row counter
                          while ($row = mysqli_fetch_array($result)) { ?>
                              <ol> 
                                  <tr>
                                      <td><p class=" text-center text-sm font-weight-bold mb-0"><?php echo $counter++; ?></p></td> <!-- Row number -->
                                      <td><p class="text-sm font-weight-bold mb-0"><?php echo htmlspecialchars($row['studid']); ?></p></td> <!-- Student ID -->
                                      <td><p class="text-sm font-weight-bold mb-0"><?php echo htmlspecialchars($row['studname']); ?></p></td> <!-- Student Name -->
                                      <td><p class="text-sm font-weight-bold mb-0"><?php echo htmlspecialchars($row['pass']); ?></p></td> <!-- Password -->
                                      <td><p class="text-sm font-weight-bold mb-0"><?php echo htmlspecialchars($row['mail']); ?></p></td> <!-- Mail -->
                                      <td><p class="text-sm font-weight-bold mb-0"><?php echo htmlspecialchars($row['sem']); ?></p></td> <!-- Semester -->
                                      <td><p class="text-sm font-weight-bold mb-0"><?php echo htmlspecialchars($row['status']); ?></p></td> <!-- Status -->
                                      <td>
                                      <a href="editstudent.php?studid=<?php echo $row['studid']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                      <button class="btn btn-danger btn-sm delete-btn" data-studid="<?php echo $row['studid']; ?>">Delete</button>                                      </td>
                                    </tr>
                              </ol>
                          <?php } 
                      } else {
                          echo "<tbody><tr><td colspan='6'>There is no student's account.</td></tr></tbody>";
                      }
                      ?>

                            
                          </tbody>
                        </table>
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
    <script src="../sweetalert2/package/dist/sweetalert2.min.js"></script>
    <!-- tables things -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
      $(document).ready( function () {
        $('#myTable').DataTable();
      });
    
     // Attach event listener to all delete buttons
     document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const studid = this.getAttribute('data-studid');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to delete handler with the studid
                        window.location.href = `deletestudent.php?studid=${studid}`;
                    }
                });
            });
        });
    });
    </script>
  </body>
</html>