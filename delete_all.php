<?php
// SQL Server connection details
$serverName = "ITHP846\\SQLEXPRESS";
$connectionOptions = array(
    "Database" => "nssdata",
    "Uid" => "",
    "PWD" => ""
);

// Establish the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

// Update all FLAG values to 0
$sql = "UPDATE StockData SET FLAG = '0'";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die("Error updating data: " . print_r(sqlsrv_errors(), true));
}

// Redirect back to the main page
header("Location: view_data.php");
exit();

// Close connection
sqlsrv_close($conn);
?>
