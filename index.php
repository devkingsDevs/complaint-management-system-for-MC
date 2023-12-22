<?php

include "inc/db.php";

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LOGIN</title>

    <link rel="stylesheet" href="css/index_style.css">
    <link rel="shortcut icon" href="img/uvalogo.png" type="image/png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body>
    <div class="container">
        <input type="checkbox" id="check">
        <div class="login form">
            <header>LOGIN</header>

            <form id="loginForm">
                <input type="text" id="mobileNumber" placeholder="Enter your phone number">
                <input type="text" id="pinCode" placeholder="Enter your pin code">
                <select name="role" id="role">
                    <option value="admin" selected>Admin</option>
                    <option value="super_admin">Super Admin</option>
                </select>
                <input type="button" class="button" name="login_btn" onclick="submitForm()" value="LOGIN">
            </form>
        </div>
    </div>



    <script>
        function submitForm() {
            var mobileNumber = $("#mobileNumber").val();
            var pinCode = $("#pinCode").val();
            var role = $("#role").val();

            $.ajax({
                type: "POST",
                url: "login.php",
                data: {
                    mobileNumber: mobileNumber,
                    pinCode: pinCode,
                    role: role
                },
                success: function(response) {
                    if (response === "Login failed") {
                        // Show SweetAlert for incorrect login
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: 'Incorrect mobile number, PIN code, or role.',
                        });
                    } else {
                        // Redirect to the appropriate dashboard on successful login
                        window.location.href = response;
                    }
                },
                error: function(error) {
                    console.log(error);
                    alert("Login failed. Please try again.");
                }
            });
        }
    </script>



</body>

</html>