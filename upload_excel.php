<?php
// Include autoload file for PhpSpreadsheet
require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

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

if (isset($_POST['submit'])) {
    $file = $_FILES['excelFile']['tmp_name'];
    $fileType = pathinfo($_FILES['excelFile']['name'], PATHINFO_EXTENSION);

    // Validate file type
    if (!in_array($fileType, ['xlsx', 'xls'])) {
        die("Invalid file type. Please upload an Excel file.");
    }

    // Load Excel file
    $spreadsheet = IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();

    // Iterate through rows
    $rowIndex = 0;
    foreach ($worksheet->getRowIterator() as $row) {
        $rowIndex++;
        if ($rowIndex == 1) continue; // Skip header row if applicable

        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);
        $data = [];

        foreach ($cellIterator as $cell) {
            $value = trim(htmlspecialchars($cell->getValue()));
            $data[] = ($value === 'null' || $value === '') ? null : $value;
        }

        // Debugging: Print row data before processing
        // echo "<pre>Row $rowIndex Data Before Processing: ";
        // print_r($data);
        // echo "</pre>";

        // Ensure at least one of these critical fields is present
        if (empty($data[3]) && empty($data[4])) {
            echo "Skipping row $rowIndex due to missing required fields.<br>";
            continue;
        }

        // Convert Excel date format properly
        if (isset($data[0]) && is_numeric($data[0])) {
            $data[0] = date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($data[0]));
        } elseif (!empty($data[0]) && !strtotime($data[0])) {
            die("Invalid date format in row $rowIndex: " . $data[0]);
        }

        // Fill missing values with appropriate defaults
        for ($i = 0; $i < 17; $i++) {
            if (!isset($data[$i]) || $data[$i] === null) {
                $data[$i] = ($i >= 5) ? 0 : ''; // Default numbers to 0, others to ''
            }
        }

        // Convert numeric columns properly
        for ($i = 5; $i < count($data); $i++) {
            $data[$i] = is_numeric(str_replace(',', '', $data[$i])) ? floatval(str_replace(',', '', $data[$i])) : 0;
        }

        // Debugging: Print row data after processing
        // echo "<pre>Row $rowIndex Data After Processing: ";
        // print_r($data);
        // echo "</pre>";

        // Prepare SQL query
        $sql = "INSERT INTO StockData 
                (Date, MKT, SERIES, SYMBOL, SECURITY, PREV_CL_PR, OPEN_PRICE, HIGH_PRICE, LOW_PRICE, CLOSE_PRICE, Average_Price, 
                 NET_TRDVAL, NET_TRDQTY, TRADES, Delivery_qty, HI_52_WK, LO_52_WK) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = sqlsrv_prepare($conn, $sql, $data);

        // Execute statement and check for errors
        if (!sqlsrv_execute($stmt)) {
            echo "<pre>SQL Error in row $rowIndex: " . print_r(sqlsrv_errors(), true) . "</pre>";
            die("Error inserting data in row $rowIndex.");
        }
    }

   
    echo "<script>alert('Excel data successfully uploaded to the database!.');window.location.href = 'index.php';</script>";
}

sqlsrv_close($conn);
?>



