<?php
session_start();

include("../db.php");

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $studid = $_POST['studid'];
    $mail = $_POST['mail'];
    $password = $_POST['pass'];

    // Validate email, STUDENT ID, and check for duplicates
    if(!empty($mail) && !empty($password) && preg_match("/^AM\d{10}$/", $studid) && filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        // Check if the student ID already exists
        $query_check = "SELECT * FROM student WHERE studid = '$studid' LIMIT 1";
        $result_check = mysqli_query($con, $query_check);

        if (mysqli_num_rows($result_check) > 0) {
            // If the student ID exists, show an alert
            echo "<script type='text/javascript'> alert('Student ID already exists'); </script>";
        } else {
            // Insert new student if ID doesn't exist
            $query_insert = "INSERT INTO student (studid, mail, pass) VALUES ('$studid', '$mail', '$password')";
            mysqli_query($con, $query_insert);

            echo "<script type='text/javascript'> alert('Successfully Registered'); </script>";
        }
    } else {
        echo "<script type='text/javascript'> alert('Invalid Student ID or Email format'); </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <title>SAS - STUDENT</title>
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/logo1.png">
  <link rel="icon" type="image/png" href="assets/img/logo1.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">
  
  <style>
    body {
      background-color: #f7f9fc;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      
    }
    .bg {
      /* The image used */
      background-image: url("assets/img/siswi2.png");

      /* Full height */
      height: 100%; 

      /* Center and scale the image nicely */
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }
    .wrapper-page {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .card {
      border: none;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
      border-radius: 15px;
      overflow: hidden;
      
    }

    .card-header {
      color: white;
      padding: 25px;
      text-align: center;
    }

    .card-title {
      font-size: 30px;
      font-family:"Times New Roman", Times, serif;
      color: #000066;
      font-weight 20px; ;
      margin-bottom: 0;
    }

    .form-control {
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      padding: 12px;
    }

    .form-control:focus {
      box-shadow: none;
      border-color: #749ac5;
    }

    .input-group-text {
      background-color: #f1f1f1;
      border: 1px solid #e0e0e0;
    }

    .btn-common {
      background-color: #4a90e2;
      color: white;
      font-weight: bold;
      border-radius: 8px;
      padding: 10px 20px;
      border: none;
    }

    .btn-common:hover {
      background-color: #bd9c99;
    }

    .form-check-input:checked {
      background-color: #4a90e2;
      border-color: #4a90e2;
    }

    .text-muted a {
      color: #4a90e2;
      text-decoration: none;
    }

    .text-muted a:hover {
      color: #3a7fc0;;
      text-decoration: underline;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body class="bg-gray-200" >
  <div class="bg">
    <div class="wrapper-page">
      <div class="container">
      
        <div class="row justify-content-center">
          <div class="col-lg-5 col-md-12 col-xs-12">
            <div class="card shadow">
              <div class="card-header border-bottom text-center">
              <img src="assets/img/uptm.png" alt="" style="width: 200px; height: 100px;">  
                <hr>   
                <h4 class="card-title">STUDENT REGISTER</h4> 
              </div>
              <div class="card-body">
                <form class="form-horizontal m-t-20" role="form" method="POST" onsubmit="return validateForm()">
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <span class="input-group-text">
                        <i class="bi bi-envelope"></i> <!-- Email icon -->
                      </span>
                      <input type="email" class="form-control" name="mail" placeholder="Email">
                    </div>
                    <div class="input-group mb-3">
                      <span class="input-group-text">@</span>
                      <input type="text" class="form-control" name="studid" placeholder="Your Student ID">
                    </div>
                    <div class="input-group mb-3">
                      <span class="input-group-text">
                        <i class="bi bi-lock"></i> <!-- Password icon -->
                      </span>
                      <input type="password" class="form-control" name="pass" placeholder="Password">
                    </div>
                    
                  </div>
                  <div class="form-group text-center m-b-20">
                    <button class="btn btn-dark btn-block" type="submit">REGISTER</button>
                  </div>
                  <div class="form-group m-t-10 mb-0">
                    <div class="text-center">
                      <a href="login.php" class="text-muted">Already have an account?</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="footer position-absolute bottom-0 py-2 w-100">
    <div class="container">
      <div class="row align-items-center justify-content-lg-between">
        <div class="col-12 col-md-6 my-auto">
          <div class="copyright text-center text-sm text-white text-lg-start">
            © <script>document.write(new Date().getFullYear())</script>,
            made with <i class="bi bi-heart-fill"></i> by
            <a href="#" class="font-weight-bold text-white" target="_blank">SAS</a>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <ul class="nav nav-footer justify-content-center justify-content-lg-end">
            <li class="nav-item">
              <a href="#" class="nav-link text-white" target="_blank">Blog</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link pe-0 text-white" target="_blank">License</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function validateForm() {
        // Validate STUDENT ID starts with AM
        const studid = document.getElementById('studid').value;
        const email = document.getElementById('mail').value;
        const studidPattern = /^AM\d{10}$/; // Adjust the pattern based on your actual requirement

        if (!studidPattern.test(studid)) {
            alert("Invalid Student ID. It should start with 'AM' followed by 10 digits.");
            return false;
        }

        // Email validation is automatically handled by HTML5 (type="email")
        return true;
    }
  </script>
</body>
</html>
