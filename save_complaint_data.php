<?php

session_start();
include "inc/db.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
$user_id = $_SESSION['user_id'];
$name = $_POST['name'];
$address = $_POST['address'];
$mobile = $_POST['phone'];
$whatsapp = $_POST['whatsNum'];
$complaint = $_POST['complaintType'];
$complaintInput = $_POST['complainText'];
$responsible = $_POST['responsible'];

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);

// Check if the file is an actual image
$check = getimagesize($_FILES["image"]["tmp_name"]);
if ($check === false) {
    echo "Error: File is not an image.";
    exit();
}

// Move the file to the desired directory
if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    echo "Error: There was an error uploading your file.";
    exit();
}

$sql = "INSERT INTO images (name, complaint, complaintInput, filename, filepath) VALUES ('$name', '$complaint', '$complaintInput', '" . basename($_FILES["image"]["name"]) . "', '" . $target_file . "')";
    if ($conn->query($sql) === TRUE) {
        echo "Record added to database successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>