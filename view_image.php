<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image</title>

    <link rel="shortcut icon" href="img/uvalogo.png" type="image/png">

    <style>
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #3d3d3d;
        }

        img {
            margin-top: 20px;
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
    </style>

</head>

<body>

    <div class="container">

        <?php
        $folderPath = "uploads/";

        $filename = isset($_GET['filename']) ? $_GET['filename'] : '';

        echo "<img src='" . $folderPath . $filename . "' alt='Complaint Image'>";
        ?>

    </div>

</body>

</html>
