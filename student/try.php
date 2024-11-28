<?php
ob_start();
session_start();
include('../db.php');

// Set the content type to JSON

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if (!isset($_SESSION['studid'])) {
    echo json_encode(['error' => 'Student ID not found. Please log in to check your application status.']);
    exit();
}

// Handle AJAX request for fetching rooms based on selected floor
if (isset($_GET['fetch_rooms']) && !empty($_GET['floor'])) {
    $floor = filter_var($_GET['floor'], FILTER_SANITIZE_NUMBER_INT);

    try {
        $stmtRooms = $con->prepare("SELECT room_id, room, status, current_occupancy, capacity FROM room WHERE floor = ? ORDER BY room");
        $stmtRooms->bind_param("i", $floor);
        $stmtRooms->execute();
        $roomsResult = $stmtRooms->get_result();

        $rooms = [];
        while ($row = $roomsResult->fetch_assoc()) {
            $rooms[] = $row;
        }

        // If rooms are found, return as JSON
        if (!empty($rooms)) {
            echo json_encode($rooms);
        } else {
            echo json_encode(["error" => "No rooms found for this floor."]);
        }
    } catch (Exception $e) {
        // Return JSON error message if an exception occurs
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
    exit();
}

// Handle room booking logic
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['booking'])) {
    if (!isset($_POST['room_id']) || empty($_POST['room_id'])) {
        echo json_encode(['error' => 'Room not selected. Please choose a room before booking.']);
        exit();
    }

    $applyid = filter_var($_POST['applyid'], FILTER_SANITIZE_STRING);
    $studid = filter_var($_POST['studid'], FILTER_SANITIZE_STRING);
    $room_id = filter_var($_POST['room_id'], FILTER_SANITIZE_NUMBER_INT);
    $booking_date = filter_var($_POST['booking_date'], FILTER_SANITIZE_STRING);

    // Check if application status is approved
    $stmtStatus = $con->prepare("SELECT status FROM apply WHERE applyid = ? AND studid = ?");
    $stmtStatus->bind_param("ss", $applyid, $studid);
    $stmtStatus->execute();
    $resultStatus = $stmtStatus->get_result();

    if ($resultStatus->num_rows > 0) {
        $application = $resultStatus->fetch_assoc();
        if ($application['status'] !== 'Approved') {
            echo json_encode(['error' => 'Your application is not approved. You cannot book a room.']);
            exit();
        }
    } else {
        echo json_encode(['error' => 'Invalid application or student ID.']);
        exit();
    }

    // Check room availability
    $stmtRoom = $con->prepare("SELECT current_occupancy, capacity, status FROM room WHERE room_id = ?");
    $stmtRoom->bind_param("i", $room_id);
    $stmtRoom->execute();
    $resultRoom = $stmtRoom->get_result();

    if ($resultRoom->num_rows > 0) {
        $roomData = $resultRoom->fetch_assoc();
        $currentOccupancy = $roomData['current_occupancy'];
        $capacity = $roomData['capacity'];
        $status = $roomData['status'];

        // Allow booking only if the room is available and not fully occupied
        if ($status === 'available' && $currentOccupancy < $capacity) {
            // Proceed with booking
            $stmtBooking = $con->prepare("INSERT INTO booking (studid, room_id, booking_date) VALUES (?, ?, ?)");
            $stmtBooking->bind_param("sis", $studid, $room_id, $booking_date);

            if ($stmtBooking->execute()) {
                // Update room occupancy
                $newOccupancy = $currentOccupancy + 1;
                $updateRoom = $con->prepare("UPDATE room SET current_occupancy = ? WHERE room_id = ?");
                $updateRoom->bind_param("ii", $newOccupancy, $room_id);
                $updateRoom->execute();

                // Generate the PDF
                try {
                    generatePDF($studid, $room_id, $booking_date);
                } catch (Exception $e) {
                    echo json_encode(['error' => 'PDF generation failed: ' . $e->getMessage()]);
                    exit();
                }

                // Return JSON success response
                error_log("Booking successful for student ID: " . $studid);
                echo json_encode(['success' => 'Room booked successfully.']);
                exit();
            } else {
                echo json_encode(['error' => 'Failed to book the room.']);
            }
        } else {
            echo json_encode(['error' => 'The selected room is either fully booked or unavailable.']);
        }
    } else {
        echo json_encode(['error' => 'Room not found.']);
    }
    exit();
}
ob_end_flush();

// Function to generate a booking confirmation PDF
function generatePDF($studid, $room_id, $booking_date) {
    require_once('../TCPDF-main/tcpdf.php');  // Ensure TCPDF is included

    // Create a new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator('Siswi Accommodation System');
    $pdf->SetAuthor('UPTM');
    $pdf->SetTitle('Room Booking Confirmation');
    $pdf->SetSubject('Confirmation of Room Booking');
    $pdf->SetKeywords('Booking, Room, Confirmation, PDF');

    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Confirmation of Room Booking', 'Generated by Siswi Accommodation System');
    
    // Set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // Set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
    // Set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // Add a page
    $pdf->AddPage('P', 'A4');

    // Set content font
    $pdf->SetFont('helvetica', '', 12);

    // Title
    $pdf->SetFont('helvetica', 'B', 16);  // Bold title font
    $pdf->Cell(0, 15, 'Room Booking Confirmation', 0, 1, 'C');
    $pdf->Ln(8);  // Line break

    // Student information table
    $tbl = '
    <table cellspacing="0" cellpadding="6" border="1">
        <tr>
            <th>Student ID</th>
            <td>' . htmlspecialchars($studid) . '</td>
        </tr>
        <tr>
            <th>Room Number</th>
            <td>' . htmlspecialchars($room_id) . '</td>
        </tr>
        <tr>
            <th>Booking Date</th>
            <td>' . htmlspecialchars($booking_date) . '</td>
        </tr>
    </table>';
    
    // Write the HTML table to the PDF
    $pdf->writeHTML($tbl, true, false, false, false, '');

    // Output the PDF (save or download)
    $pdf->Output(__DIR__ . '/booking_invoice/' . $studid . '_booking.pdf', 'F');
}
?>
