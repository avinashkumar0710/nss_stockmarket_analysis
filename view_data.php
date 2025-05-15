<?php
// SQL Server connection details
$serverName = "ITHP846\\SQLEXPRESS";
$connectionOptions = array("Database" => "nssdata", "Uid" => "", "PWD" => "");

// Establish the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

// Query to fetch data ordered by SECURITY
$sql = "SELECT * FROM StockData where flag='1' ORDER BY SECURITY, Date";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die("Error fetching data: " . print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Uploaded Data</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #f4f4f4;
            font-family: "Poppins", sans-serif;
        }

        .container-fluid {
            margin-top: 60px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            font-size: 15px;
            max-height: 800px;
            overflow: auto;
        }

        header {
            width: 100%;
            background-color: rgb(92, 98, 104);
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
            position: fixed;
            top: 0;
            left: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .security-header {
            background: #f0f0f0;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            background-color: #333;
            color: white;
            padding: 10px;
            font-size: 14px;
        }

        header {
    width: 100%;
    background-color:rgb(92, 98, 104);
    color: white;
    text-align: center;
    padding: 20px;
    font-size: 24px;
    font-weight: bold;
    position: fixed;  /* Keeps it at the top */
    top: 0;
    left: 0;
}
    </style>
</head>
<body>
<header>Stock Data</header>
<div class='container-fluid'>

<table class="table table-bordered border-success" border="3">
<thead style="position: sticky; top: 0; background-color: green; z-index: 1;">
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>MKT</th>
                <th>SERIES</th>
                <th>SYMBOL</th>
                <th>PREV_CL_PR</th>
                <th>OPEN_PRICE</th>
                <th>HIGH_PRICE</th>
                <th>LOW_PRICE</th>
                <th>CLOSE_PRICE</th>
                <th>Average_Price</th>
                <th>NET_TRDVAL</th>
                <th>NET_TRDQTY</th>
                <th>TRADES</th>
                <th>Delivery_qty</th>
                <th>HI_52_WK</th>
                <th>LO_52_WK</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $serial = 1;
            $prevSecurity = ""; // To track security groups

            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                // If SECURITY changes, print a new section header
                if ($prevSecurity != $row['SECURITY']) {
                    echo "<tr class='security-header'>
                            <td colspan='17'>{$row['SECURITY']}</td>
                          </tr>";
                    $prevSecurity = $row['SECURITY'];
                    $serial = 1; // Reset serial number for each group
                }

                // Display the data
                echo "<tr>
                        <td>{$serial}</td>
                        <td>" . $row['Date']->format('Y-m-d') . "</td>
                        <td>" . htmlspecialchars($row['MKT']) . "</td>
                        <td>" . htmlspecialchars($row['SERIES']) . "</td>
                        <td>" . htmlspecialchars($row['SYMBOL']) . "</td>
                        <td>" . htmlspecialchars($row['PREV_CL_PR']) . "</td>
                        <td>" . htmlspecialchars($row['OPEN_PRICE']) . "</td>
                        <td>" . htmlspecialchars($row['HIGH_PRICE']) . "</td>
                        <td>" . htmlspecialchars($row['LOW_PRICE']) . "</td>
                        <td>" . htmlspecialchars($row['CLOSE_PRICE']) . "</td>
                        <td>" . htmlspecialchars($row['Average_Price']) . "</td>
                        <td>" . htmlspecialchars($row['NET_TRDVAL']) . "</td>
                        <td>" . htmlspecialchars($row['NET_TRDQTY']) . "</td>
                        <td>" . htmlspecialchars($row['TRADES']) . "</td>
                        <td>" . htmlspecialchars($row['Delivery_qty']) . "</td>
                        <td>" . htmlspecialchars($row['HI_52_WK']) . "</td>
                        <td>" . htmlspecialchars($row['LO_52_WK']) . "</td>
                      </tr>";
                $serial++;
            }
            ?>
        </tbody>
    </table>
   
</div>
<div style="text-align:left;">
    <form action="delete_all.php" method="post" onsubmit="return confirmDelete();">
        <button type="submit" style="background-color: green; border-radius: 25px; color: white; padding: 10px 20px; border: none; cursor: pointer;">
            Delete All Data
        </button>
    </form>
</div>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete all data? This action cannot be undone.");
    }
</script>


<footer>
    &copy; 2025 Excel Data Uploader | All Rights Reserved |
    <a href="index.php"><button>Go Back Page</button></a>
</footer>

</body>
</html>

<?php
// Close the connection
sqlsrv_close($conn);
?>
