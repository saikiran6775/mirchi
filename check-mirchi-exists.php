<?php
include_once('db-connect.php'); // Include DB Connection

if (!empty($_POST['mirchi'])) {
    $mirchi = mysqli_real_escape_string($conn, $_POST['mirchi']);
    $id = intval($_POST['id']); // Get ID for edit mode
    $mode = $_POST['mode']; // Check if it's Add or Edit

    if ($mode == "edit") {
        // Check for duplicates while editing (exclude current record)
        $sql = "SELECT id FROM mirchi_types WHERE mirchi_type = '$mirchi' AND id != '$id'";
    } else {
        // Check for duplicates when adding
        $sql = "SELECT id FROM mirchi_types WHERE mirchi_type = '$mirchi'";
    }

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "exists"; // Send response to AJAX
    } else {
        echo "available"; // Value is unique
    }
}
?>
