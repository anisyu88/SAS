<?php
session_start();
include("../db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $studid = filter_var($_POST['studid'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

    if (!empty($studid) && !empty($password)) {
        $stmt = $con->prepare("SELECT * FROM student WHERE studid = ? LIMIT 1");
        $stmt->bind_param("s", $studid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            if ($user_data['pass'] == $password) {
                $_SESSION['studid'] = $user_data['studid'];
                header("Location: home.php");
                exit;
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Incorrect password',
                            text: 'Please try again.'
                        });
                    });
                </script>";
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Student ID not found',
                        text: 'Please check your ID and try again.'
                    });
                });
            </script>";
        }
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing information',
                    text: 'Please fill in both Student ID and password.'
                });
            });
        </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/logo1.png">
  <link rel="icon" type="image/png" href="assets/img/logo1.png">

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
   <!-- Fonts -->
   <link rel="stylesheet" type="text/css" href="assets/fonts/line-icons.css">

   <link rel="stylesheet" type="text/css" href="assets/css/icons.css">
   <link rel="stylesheet" href="../sweetalert2/package/dist/sweetalert2.min.css">
   <style>
    body {
      background-color: #f7f9fc;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      
    }
    .bg {
      /* The image used */
      background-image: url("assets/img/siswi2.png");

      /* Full height */
      height: 90%; 

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
      font-weight: ;
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
<body class="bg-gray-200">
    

  <div class="bg">
    <div class="wrapper-page">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-12 col-xs-12">
              <div class="card shadow">
                <div class="card-header border-bottom text-center" >
                <img src="assets/img/uptm.png" alt="" style="width: 200px; height: 100px;">  
                <hr>   
                <h4 class="card-title">STUDENT LOGIN</h4> 
                </div>
                <div class="text-center">
                 
              </div>

                <div class="card-body">
                  <form class="form-horizontal m-t-20" role="form"  method="POST">
                    <div class="form-group">
                      
                      <div class="input-group mb-3">
                        <div class="input-group-text">@</div>
                      <input type="text" class="form-control" name="studid" placeholder="AM XXXXXXX" required>
                    </div>
                    
                    <div class="input-group mb-3">
                      <span class="input-group-text">
                        <i class="lni-lock"></i><!-- Password icon -->
                      </span>
                      <input type="password" class="form-control" name="pass" placeholder="Password" required>
                    </div>
    
                  <div class="form-group text-center m-t-20">
                    <button class="btn btn-dark btn-block" type="submit">LOG IN</button>
                  </div>
                  <div class="form-group m-t-10 mb-0">
                    <div class="text-center">
                      <p> Don't have an Account? </p>
                      <a href="signup.php" class="text-muted">SIGN UP</a>
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
              <a href="https://www.uptm.edu.my/index.php" class="nav-link text-white" target="_blank">UPTM</a>
            </li>
            
          </ul>
        </div>
      </div>
    </div>
  </footer>

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css"></script>
  <script src="../sweetalert2/package/dist/sweetalert2.min.js"></script>

</body>
</html>