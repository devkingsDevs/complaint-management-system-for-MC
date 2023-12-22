<?php
include 'inc/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mobileNumber = $_POST['mobileNumber'];
    $pinCode = $_POST['pinCode'];
    $selectedRole = $_POST['role']; // Role selected during login

    $stmt = $conn->prepare("SELECT id, pin_code, role FROM user_data WHERE mobile_number = '$mobileNumber'");
    // $stmt->bind_param("s", $mobileNumber);
    $stmt->execute();
    $stmt->bind_result($id, $pin_code, $role);

    if ($stmt->fetch() && password_verify($pinCode, $pin_code) && $role == $selectedRole) {
        session_start();
        $_SESSION['user_id'] = $id;
        $_SESSION['user_role'] = $role;

        if ($role == 'admin') {
            echo "admin_dashboard.php";
        } else {
            echo "superAdmin_dashboard.php";
        }
    } else {
        echo "Login failed";
    }

    $stmt->close();
    $conn->close();
}
?>
