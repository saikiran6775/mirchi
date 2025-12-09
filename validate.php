<?php
// Include database connection
include_once('db-connect.php');

// Check if the lot number was passed via POST
if (isset($_POST['desire_no_bag'])) {
    $lotNumber = mysqli_real_escape_string($conn, $_POST['desire_no_bag']);

    // Get today's date
    $today = date('Y-m-d');

    // Query to check if the given lot number exists for today's date
    $sql = "SELECT * FROM weight WHERE lot_no = '$lotNumber' AND DATE(date) = '$today' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    // Check if a matching record is found
    if (mysqli_num_rows($result) > 0) {
        echo "not available";  // Lot number is not available for today
    } else {
        echo "available";  // Lot number is available
    }
}
?>
