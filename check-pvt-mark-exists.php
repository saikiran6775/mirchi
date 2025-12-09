<?php
include_once('db-connect.php'); 

$batch = trim(strtolower(mysqli_real_escape_string($conn, $_POST['batch']))); // Trim & lowercase input
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$mode = $_POST['mode'];

if ($mode == "edit") {
    // Exclude the current ID when checking for duplicates
    $sql = "SELECT id FROM bag_batch WHERE LOWER(TRIM(batch)) = '$batch' AND id != '$id' AND status = '1'";
} else {
    // Check if the batch name already exists
    $sql = "SELECT id FROM bag_batch WHERE LOWER(TRIM(batch)) = '$batch' AND status = '1'";
}

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    echo "exists";
} else {
    echo "available";
}
?>
