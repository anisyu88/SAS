<?php
session_start();
include('../db.php');

// Check if the session variable is set
$studid = isset($_SESSION['studid']) ? $_SESSION['studid'] : null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Success</title>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="../sweetalert2/package/dist/sweetalert2.min.css">
    <style>
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
        // Check for the status parameter in the URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('status') === 'success') {
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'Room booked successfully. PDF has been generated.',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Download PDF',
                    cancelButtonText: 'Go to Profile'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Download the generated PDF
                        window.location.href = 'booking_invoice/<?php echo $studid; ?>_booking.pdf';
                    } else {
                        // Redirect to the profile page
                        window.location.href = 'profile.php';
                    }
                });
            });
        }
    </script>
</body>
</html>
