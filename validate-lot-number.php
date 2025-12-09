<?php
include "db_connect.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the lot number from the form
    $lot_no = $_POST['lot_no'];

    // Get the current date
    $date = date('Y-m-d');  // Get today's date in 'YYYY-MM-DD' format

    // Prepare and execute query to check if the lot number already exists for the current date
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM weight WHERE lot_no = :lot_no AND date = :date");
    $stmt->bindParam(':lot_no', $lot_no);
    $stmt->bindParam(':date', $date);  // Use current date here
    $stmt->execute();
    $count = $stmt->fetchColumn();

    // Return an error message if the lot number already exists for today
    if ($count > 0) {
        echo '<span style="color: red;">Error: Lot number already exists for today\'s date.</span>';
    } else {
        // No error, return an empty response (no message)
        echo '';
    }
}
?>