<?php
include('../db.php');

if (isset($_GET['studid'])) {
    $studid = mysqli_real_escape_string($con, $_GET['studid']);
    $query = "DELETE FROM student WHERE studid = '$studid'";
    $result = mysqli_query($con, $query);

    if ($result) {
        // Redirect back with a success message
        header("Location: view_student.php?message=deleted");
    } else {
        // Redirect back with an error message
        header("Location: view_student.php?message=error");
    }
}
?>
