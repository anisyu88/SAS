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
                                        <p class="text-muted m-b-30 font-14">General Question.</p>
                                            <div id="accordion">
                                                <div class="card">
                                                     <div class="card-header" id="headingOne">
                                                        <h5 class="m-0">
                                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="text-dark collapsed">
                                                                Q1: How do I apply for hostel accommodation?
                                                            </a>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                        <div class="card-body">
                                                            A1: After logging into the system, go to the "Apply" section in the sidebar. Fill in the application form with your details and required documents, then submit. You can check your application status later in the "Check Application" section                                        
                                                        </div>
                                                    </div>
                                                </div>
                                              <div class="card">
                                                <div class="card-header" id="headingTwo">
                                                    <h5 class="m-0">
                                                        <a class="collapsed text-dark" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                            Q2: How do I know if my application is approved?
                                                        </a>
                                                    </h5>
                                                </div>
                                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                                    <div class="card-body">
                                                        A2: You can view your application status in the "Check Application" section. If your application is approved, you’ll see a status update, and you’ll be able to proceed with booking.                                            
                                                    </div>
                                                </div>
                                              </div>
                                              <div class="card">
                                                <div class="card-header" id="headinglip">
                                                    <h5 class="m-0">
                                                        <a class="collapsed text-dark" data-toggle="collapse" data-parent="#accordion" href="#collapselip" aria-expanded="false" aria-controls="collapselip">
                                                        <strong>Why is my details in <b>Home</b> did not show up? </strong>
                                                        </a>
                                                    </h5>
                                                </div>
                                                <div id="collapselip" class="collapse" aria-labelledby="headinglip" data-parent="#accordion">
                                                    <div class="card-body">
                                                       You details will only show up after you register as residence                                           
                                                    </div>
                                                </div>
                                              </div>
                                                <div class="card">
                                                    <div class="card-header" id="headingThree">
                                                        <h5 class="m-0">
                                                        <a class="collapsed text-dark" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                            Q3: What should I do if my application is rejected?
                                                        </a>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                                        <div class="card-body">
                                                            A3: The probability of your application being rejected is low. However, if it is rejected, it might be due to a lack of available rooms. Check for any feedback in the application status, and you can also contact the warden for further details. 
                                                            Reapplying may be an option if space becomes available.                                            </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" id="headingFour">
                                                        <h5 class="m-0">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour" class="text-dark collapsed">
                                                            Q4: How do I register for accommodation after my application is approved?
                                                        </a>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                                        <div class="card-body">
                                                            A4: Once your application is approved, you can proceed to book a room based on availability.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" id="headingFive">
                                                        <h5 class="m-0">
                                                        <a class="collapsed text-dark" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                            Q5:When will I received the house key:
                                                        </a>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                                                        <div class="card-body">
                                                            A5:You will received the key on the day check in . Please make sure to download or print your booking invoice so the key collection process can go smoothly.
                                                            if you forgot to download it you can find the pdf in profile 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" id="headingSix">
                                                        <h5 class="m-0">
                                                        <a class="collapsed text-dark" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                            Q6: Can I choose my room or block?
                                                        </h5>
                                                    </div>
                                                    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
                                                        <div class="card-body">
                                                            A6: Yes, after your application is approved, you will be able to choose your room or block, based on availability.                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" id="headingSeven">
                                                        <h5 class="m-0">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven" class="text-dark collapsed">
                                                            Q7:What steps should I follow to complete my registration?
                                                        </a>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
                                                        <div class="card-body">
                                                            A7: Once your application is approved, go to the "Register" section in the sidebar. Complete the registration form by entering your personal and program details and room number. Once submitted, you’ll be officially registered.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" id="headingEight">
                                                        <h5 class="m-0">
                                                        <a class="collapsed text-dark" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                                          <strong>During Your Stay</strong> <br>
                                                            Q8: How can I update my contact information?
                                                        </a>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion">
                                                        <div class="card-body">
                                                            A8: Go to the "Profile" section to update your personal details, such as your phone number. Make sure your information is up-to-date so the administration can reach you if needed.                                           
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" id="headingNine">
                                                        <h5 class="m-0">
                                                        <a class="collapsed text-dark" data-toggle="collapse" data-parent="#accordion" href="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                                           <strong> Check-Out Process</strong> <br>
                                                            Q9: How do I check out of the accommodation?                                                    </a>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordion">
                                                        <div class="card-body">
                                                            A9: When you’re ready to check out (usually at the end of the semester), go to the "Check Out" section. Fill up the form and upload the proof of key return and submit the form.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" id="headingTen">
                                                        <h5 class="m-0">
                                                        <a class="collapsed text-dark" data-toggle="collapse" data-parent="#accordion" href="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                                            Q10: Who do I contact if I have issues with the system?
                                                        </a>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#accordion">
                                                        <div class="card-body">
                                                            A10: If you face any technical issues or have questions, please contact the system admin. You can usually find the admin’s contact information in the "HOME" in warden section.                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" id="headingEleven">
                                                        <h5 class="m-0">
                                                        <a class="collapsed text-dark" data-toggle="collapse" data-parent="#accordion" href="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                                                            Q11: Will I need to reapply each semester?                                               </a>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseEleven" class="collapse" aria-labelledby="headingEleven" data-parent="#accordion">
                                                        <div class="card-body">
                                                            A11: Yes, you need to submit a new application each semester if you wish to continue staying in the hostel. The process remains the same, starting with the "Apply" section.
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
