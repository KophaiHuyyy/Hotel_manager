<?php
require 'connect.php';;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Update status to Checked-Out in the 'checked' table
    $updateQuery = "UPDATE checked SET status = 2 WHERE id = $id";
    if ($conn->query($updateQuery) === TRUE) {
        // Log statement removed
    } else {
        // Log statement removed
    }

    // Update room status to vacant in the 'rooms' table (you may need to adjust this query based on your schema)
    $updateRoomQuery = "UPDATE rooms SET status = '0' WHERE id = (SELECT room_id FROM checked WHERE id = $id)";
    if ($conn->query($updateRoomQuery) === TRUE) {
        // Log statement removed
    } else {
        // Log statement removed
    }

    // Generate PDF
    if ($result && $result->num_rows > 0) {
        $reservation = $result->fetch_assoc();

        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, 'Reservation Receipt');

        $pdf->Ln(10);

        $pdf->Cell(40, 10, 'Room: ' . $reservation['room']);
        $pdf->Ln();

        $pdf->Cell(40, 10, 'Name: ' . $reservation['name']);
        $pdf->Ln();

        // Add more details as needed

        // Specify the path to save the PDF file
        $pdf->Output();

        // Save the PDF to a file
        
    } else {
        echo 'Error: Unable to fetch reservation information.';
    }

    // Additional actions if needed

    echo 'Success'; // Send a success response
    exit();
} else {
    echo 'Error: Invalid request.';
}
?>
