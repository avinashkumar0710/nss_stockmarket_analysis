<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel Data</title>
    
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
  font-weight: 300;
  font-style: normal;
        }

        /* Body Styling */
        body {
    background-color: #f4f4f4;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
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


        /* Form Container */
        .upload-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 15px 15px 15px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            margin-top: 320px;
        }

        /* File Input */
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            margin: 15px 0;
        }

        /* Submit Button */
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Footer */
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
    </style>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>   <!---scroll javascript---->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

    <header>Excel File Uploader</header>

    <div class="upload-container">
        <h2>Upload Excel File</h2>
        <form method="post" action="upload_excel.php" enctype="multipart/form-data">
            <input type="file" name="excelFile" required>
            <button type="submit" name="submit">Upload</button>
        </form>
        <br>
        <a href="view_data.php"><button  name="view" style="background-color: green; border-radius: 25px;" >View Data</button></a>
    </div>

    <footer>&copy; 2025 Excel Data Uploader | All Rights Reserved</footer>

</body>
</html>