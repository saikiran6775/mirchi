<?php
include("db-connect.php"); // or wherever your DB connection is

if (isset($_POST['lot_no'])) {
    $lot_no = trim($_POST['lot_no']);
    $date = date('Y-m-d');

    $stmt = $conn->prepare("SELECT COUNT(*) FROM weight WHERE lot_no = ? AND date = ?");
    $stmt->bind_param("ss", $lot_no, $date);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "<span style='color:red;'>Lot number already exists for today.</span>";
    } else {
        echo "<span style='color:green;'>Lot number is available.</span>";
    }
}
?>
