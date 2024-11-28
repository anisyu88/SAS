<?php
// Start the session
session_start();

// Check if the session variable is set
$studid = isset($_SESSION['studid']) ? $_SESSION['studid'] : null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Application Success</title>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="../sweetalert2/package/dist/sweetalert2.min.css">    <style>
        /* Custom styling for SweetAlert buttons */
        .swal2-actions .swal2-download-btn,
        .swal2-actions .swal2-profile-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            margin: 5px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }
        .swal2-actions .swal2-profile-btn {
            background-color: #007BFF;
        }
    </style>
</head>
<body>
    <!-- SweetAlert2 JavaScript -->
    <script src="../sweetalert2/package/dist/sweetalert2.min.js"></script>

    <script>
        // Check for the status parameter in the URL to trigger SweetAlert
        if (new URLSearchParams(window.location.search).get("status") === "success") {
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Application Successful!',
                    html: `Your application has been submitted successfully.<br><br>
                           <a href="apply_invoice/<?php echo $studid; ?>_application.pdf" class="swal2-download-btn" download>Download Your Application PDF</a>
                           <a href="profile.php" class="swal2-profile-btn">Go to Profile</a>`,
                    icon: 'success',
                    showConfirmButton: false, // Hide default "OK" button
                });
            });
        }
    </script>
</body>
</html>
