<?php
session_start();
include('../db.php');

// Check if student ID exists in session
if (!isset($_SESSION['studid'])) {
    echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Student ID not found. Please log in.',
            icon: 'error',
        }).then(function() {
            window.location.href = 'login.php';
        });
    </script>";
    exit;
}

// Initialize $current_page
$current_page = 'applicationstatus.php'; // Set this to the current page
$current_page = basename($_SERVER['PHP_SELF']); // Gets the current script name
if ($_SERVER['PHP_SELF'] == '/SAS_FYP/student/applicationstatus.php') {
    $current_page = 'applicationstatus.php';
} elseif ($_SERVER['PHP_SELF'] == '/SAS_FYP/student/home.php') {
    $current_page = 'home.php';
} 
// Retrieve student ID from session
$studid = $_SESSION['studid'];

// Query to retrieve student's application based on ID
$query = "SELECT applyid, studid, status FROM apply WHERE studid = ? ORDER BY applyid DESC";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $studid);
$stmt->execute();
$result = $stmt->get_result();

// Define the status and response based on application state
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $applyID = $row['applyid'];
    $status = $row['status'];
} else {
    $status = null; // No application found
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
    <link rel="stylesheet" type="text/css" href="assets/fonts/line-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
    <link rel="stylesheet" href="../sweetalert2/package/dist/sweetalert2.min.css">
</head>

<body>
<div class="app header-default side-nav-light">
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
                    <li class="nav-item dropdown <?php echo (isset($current_page) && $current_page == 'applicationstatus.php') ? 'active' : ''; ?>">
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
                </ul>
            </div>
        </div>
        <!-- Side Nav END -->

        <!-- Page Container START -->
        <div class="page-container">
            <!-- Content Wrapper START -->
            <div class="main-content">
                <div class="container-fluid">
                    <h4 class="card-title">APPLICATION STATUS</h4>
                    <div class="card-body">
                        <?php
                        if ($status) {
                            if ($status === 'Pending') {
                                echo "<div class='alert alert-info text-center'>Your application status is <strong>Pending</strong>. Please wait for further updates.</div>";
                            } elseif ($status === 'Reject') {
                                echo "<div class='alert alert-danger text-center'>Unfortunately, your application has been <strong>Rejected</strong>. Please contact administration for further details.</div>";
                            } elseif ($status === 'Approved') {
                                echo "<div class='alert alert-success text-center'>
                                        <h2>Application Approved</h2>
                                        <p>Apply ID: <strong>" . htmlspecialchars($applyID) . "</strong></p>
                                        <p>Student ID: <strong>" . htmlspecialchars($studid) . "</strong></p>
                                        <p>Select a floor to proceed with room booking.</p>
                                    </div>";
                                ?>
                                
                                <form class="forms-sample" method="POST" id="bookingForm" action="try.php">
                                    <input type="hidden" name="applyid" value="<?php echo htmlspecialchars($applyID); ?>">
                                    <input type="hidden" name="studid" value="<?php echo htmlspecialchars($studid); ?>">
                                    <input type="hidden" name="room_id" id="selected-room-id">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Choose Floor:</label>
                                        <div class="col-sm-9">
                                            <button type="button" class="btn btn-light mr-3" onclick="loadRooms(1)">Floor 1</button>
                                            <button type="button" class="btn btn-light mr-3" onclick="loadRooms(2)">Floor 2</button>
                                            <button type="button" class="btn btn-light mr-3" onclick="loadRooms(3)">Floor 3</button>
                                            <button type="button" class="btn btn-light mr-3" onclick="loadRooms(4)">Floor 4</button>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Book House:</label>
                                        <div class="col-sm-9" id="room-selection-container">
                                          <input type="hidden" name="room_id" id="selected-room-id">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Date</label>
                                        <div class="col-sm-9">
                                            <input type="date" name="booking_date" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-end">
                                        <button type="submit" name="booking" class="btn btn-light mr-3">Submit</button>
                                        <button type="button" class="btn btn-danger mr-3" onclick="window.history.back();">Cancel</button>
                                    </div>
                                </form>
                                <?php
                            }
                        } else {
                            echo "<div class='alert alert-warning text-center'>No application found. Please apply for accommodation to proceed.</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- Content Wrapper END -->
        </div>
        <!-- Page Container END -->
    </div>
</div>

<script src="assets/js/jquery-min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>

<script src="../sweetalert2/package/dist/sweetalert2.min.js"></script>
<script>
    function loadRooms(floor) {
        console.log("Loading rooms for floor:", floor); // Debugging line to confirm function call

        fetch(`try.php?fetch_rooms=1&floor=${floor}`)
            .then(response => {
                console.log("Response received:", response); // Debugging line to check response
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log("Data received:", data); // Debugging line to confirm data
                if (data.error) {
                    Swal.fire("Error", data.error, "error");
                } else if (Array.isArray(data) && data.length > 0) {
                    const roomButtons = data.map(room => {
                        if (room.status === 'available') {
                            return `<button class="swal2-confirm swal2-styled" onclick="selectRoom(${room.room_id}, '${room.room}', ${room.capacity - room.current_occupancy})">
                                        Room ${room.room} (Available capacity: ${room.capacity - room.current_occupancy})
                                    </button>`;
                        }
                    }).join('');

                    Swal.fire({
                        title: 'Select a Room',
                        html: roomButtons,
                        showCancelButton: true,
                        confirmButtonText: 'Cancel',
                    });
                } else {
                    Swal.fire("No rooms available on this floor.");
                }
            })
            .catch(error => {
                console.error("Error fetching rooms:", error);
                Swal.fire("An error occurred while fetching rooms. Please try again later.");
            });
    }

    function selectRoom(roomId, roomName, availableCapacity) {
        document.getElementById("selected-room-id").value = roomId;
        console.log("Selected room ID:", roomId); // Debugging line

        const selectedRoomDisplay = document.createElement('div');
        selectedRoomDisplay.innerHTML = `<strong>Selected Room:</strong> ${roomName} (Available Capacity: ${availableCapacity})`;

        const roomSelectionContainer = document.getElementById("room-selection-container");
        roomSelectionContainer.innerHTML = "";
        roomSelectionContainer.appendChild(selectedRoomDisplay);

        Swal.fire("Room selected. You can now proceed with booking.");
    }

    document.getElementById("bookingForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(this);
    console.log("Room ID:", formData.get("room_id")); // Log the room ID being submitted

    fetch("try.php", {
        method: "POST",
        body: formData
    })
    .then(response => {
        console.log("Response status:", response.status); // Log response status
        return response.text(); // Read the response as plain text first
    })
    .then(text => {
        console.log("Raw response:", text); // Debugging line to check raw response
        if (text.trim() === "") {
            throw new Error("Empty response from server");
        }
        try {
            // Try parsing the response text as JSON
            return JSON.parse(text);
        } catch (error) {
            console.error("JSON parsing error:", error);
            console.error("Response text:", text);
            throw new Error("Failed to parse JSON response");
        }
    })
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: "Success!",
                text: data.success,
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                // Redirect the user to success_booking.php
                window.location.href = 'success_booking.php?status=success';
            });
        } else if (data.error) {
            Swal.fire({
                title: "Error",
                text: data.error,
                icon: "error",
                confirmButtonText: "OK"
            });
        }
    })
    .catch(error => {
        console.error("Error:", error);
        Swal.fire({
            title: "Error",
            text: "An unexpected error occurred. Please try again later.",
            icon: "error",
            confirmButtonText: "OK"
        });
    });
});



</script>

</body>
</html>