<?php
include_once('db-connect.php'); // Assuming you have a file for database connection

if (isset($_GET['supplier_id'])) {
  // Get the supplier_id safely from the GET request
  $supplier_id = mysqli_real_escape_string($conn, $_GET['supplier_id']);
  
  // Prepare the SQL query to prevent SQL injection
  $query = "SELECT batch FROM bag_batch WHERE supplier_id = ?";
  
  // Initialize the prepared statement
  if ($stmt = mysqli_prepare($conn, $query)) {
    // Bind the supplier_id parameter to the prepared statement
    mysqli_stmt_bind_param($stmt, "s", $supplier_id);
    
    // Execute the prepared statement
    mysqli_stmt_execute($stmt);
    
    // Store the result of the query
    $result = mysqli_stmt_get_result($stmt);
    
    // Fetch all rows and prepare the batches array
    $batches = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $batches[] = $row;
    }
    
    // Close the prepared statement
    mysqli_stmt_close($stmt);

    // Return the batches as a JSON response
    echo json_encode($batches);
  } else {
    // If there's an issue preparing the query, return an empty array
    echo json_encode([]);
  }
} else {
  // If the supplier_id is not set, return an empty array
  echo json_encode([]);
}
?>
