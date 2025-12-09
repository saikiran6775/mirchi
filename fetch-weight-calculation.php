<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Include the database connection file
include_once('db-connect.php');

// Fetch filter parameters
$supplier = isset($_POST['supplier']) ? $_POST['supplier'] : '';
$startdate = isset($_POST['startdate']) ? $_POST['startdate'] : '';
$enddate = isset($_POST['enddate']) ? $_POST['enddate'] : '';
$month = isset($_POST['month']) ? $_POST['month'] : '';
$pvt_mark = isset($_POST['pvt_mark']) ? $_POST['pvt_mark'] : '';

// Determine the user_id
$user_id = ($_SESSION['user_id'] == $_SESSION['merchant_id']) ? $_SESSION['user_id'] : $_SESSION['merchant_id'];

// Base query
$query = "
    SELECT 
        w.id, 
        w.date, 
        w.no_of_bags, 
        w.net_weight, 
        w.supplier, 
        s.supplier AS supplier_name, 
        w.total_amount, 
        w.lot_no, 
        w.pvt_mark
    FROM weight w
    JOIN suppliers s ON w.supplier = s.id
    WHERE w.status = 1 AND w.user_id = ?
";

// Add filters dynamically
$params = [$user_id];
$param_types = 'i'; // 'i' for integer user_id

if ($supplier) {
    $query .= " AND w.supplier = ?";  // Search using supplier ID
    $params[] = $supplier;
    $param_types .= 'i'; // Supplier ID is an integer
}
if ($startdate) {
    $query .= " AND w.date >= ?";
    $params[] = $startdate;
    $param_types .= 's';
}
if ($enddate) {
    $query .= " AND w.date <= ?";
    $params[] = $enddate;
    $param_types .= 's';
}
if ($month) {
    $query .= " AND DATE_FORMAT(w.date, '%Y-%m') = ?";
    $params[] = $month;
    $param_types .= 's';
}
if ($pvt_mark) {
    $query .= " AND w.pvt_mark LIKE ?";
    $params[] = "%$pvt_mark%";
    $param_types .= 's';
}

// Order by date descending
$query .= " ORDER BY w.date DESC";

// Prepare the statement
$stmt = $conn->prepare($query);

if (!$stmt) {
    echo json_encode(["error" => "❌ Query Preparation Failed: " . $conn->error]);
    exit();
}

// Bind parameters dynamically
if (!empty($params)) {
    $stmt->bind_param($param_types, ...$params);
}

// Execute the query
if (!$stmt->execute()) {
    echo json_encode(["error" => "❌ Query Execution Failed: " . $stmt->error]);
    exit();
}

$result = $stmt->get_result();

// Prepare the result array
$weight_entries = [];
$id = 1;

while ($row = $result->fetch_assoc()) {
    $row['id'] = $id++;
    $row['feedback'] = $row['pvt_mark'] ? htmlspecialchars($row['pvt_mark']) : 'No feedback available';
    $weight_entries[] = $row;
}

$stmt->close();
$conn->close();

// Return data as JSON
echo json_encode(["data" => $weight_entries]);
?>
