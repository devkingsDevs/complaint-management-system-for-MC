<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<?php

include "inc/db.php";

if (isset($_POST['submit'])) {

    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $mobile = $_POST['phone'];
    $whatsapp = $_POST['whatsNum'];
    $complaint = $_POST['complaintType'];
    $complaintInput = $_POST['complainText'];
    $responsible = $_POST['responsible'];

    $status = "Pending";

    $file_name = $_FILES['image']['name'];
    $tempName = $_FILES['image']['tmp_name'];
    $folder = 'uploads/' . $file_name;

    $query = mysqli_query($conn, "INSERT INTO informations (name, address, mobile_num, whatsapp_num, complain, complaintText, complaintImage, res_branch, status) VALUES ('$name', '$address', '$mobile', '$whatsapp', '$complaint', '$complaintInput', '$file_name', '$responsible', '$status')");

    if ($query) {
        if (move_uploaded_file($tempName, $folder)) {
            echo "<script>alert('Your record with complaint image successfully saved')</script>";
        } else {
            echo "<script>alert('Your record has been successfully saved');</script>";
        }
    } else {
        echo "<script>alert('Record updating failed');</script>";
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/dashboard.css" />

    <link rel="shortcut icon" href="./img/uvalogo.png" type="image/png">

    <title>COMPLAINT MANAGEMENT</title>

    <style>
        .navbar {
            background: white;
            padding-right: 15px;
            padding-left: 15px;
        }

        .navdiv {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo a {
            font-size: 25px;
            font-weight: 600;
            text-transform: uppercase;
            color: black;
            text-decoration: none;
        }

        li {
            list-style: none;
            display: inline-block;
        }

        li a {
            color: black;
            font-size: 18px;
            font-weight: 400;
            margin-right: 25px;
            text-decoration: none;
        }

    </style>

</head>

<body>

    <nav class="navbar">
        <div class="navdiv">
            <div class="logo"><a href="">Complaint Management</a> </div>
            <ul>
                <li><a href="#"><?php echo date("Y-m-d | l")?></a></li>
                <li><a href="logout.php" style="color: red;">LOGOUT</a></li>
               
            </ul>
        </div>
    </nav>



    <form method="post" enctype="multipart/form-data" class="form">
        <h2 class="text-center">COMPLAINT MANAGEMENT</h2>
        <!-- Progress bar -->
        <div class="progressbar">
            <div class="progress" id="progress"></div>

            <div class="progress-step progress-step-active"></div>
            <div class="progress-step"></div>
            <div class="progress-step"></div>
            <div class="progress-step"></div>
        </div>

        <!-- Steps -->
        <div class="form-step form-step-active">
            <div class="input-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" />
            </div>
            <div class="input-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" />
            </div>
            <div class="">
                <a href="#" class="btn btn-next width-50 ml-auto">Next</a>
            </div>
        </div>
        <div class="form-step">
            <div class="input-group">
                <label for="phone">Mobile Number</label>
                <input type="text" name="phone" id="phone" />
            </div>
            <div class="input-group">
                <label for="whatsNum">Whatsapp Number</label>
                <input type="text" name="whatsNum" id="whatsNum" />
            </div>
            <div class="btns-group">
                <a href="#" class="btn btn-prev">Previous</a>
                <a href="#" class="btn btn-next">Next</a>
            </div>
        </div>
        <div class="form-step">
            <div class="input-group">
                <label>Complaint</label>

                <select name="complaintType" id="complaintType" onchange="showInputField()">
                    <option value="Unauthorized Business">Unauthorized Business</option>
                    <option value="Assessment Issues">Assessment Issues</option>
                    <option value="Waste Management">Waste Management</option>
                    <option value="Vehicle Parking problem">Vehicle Parking problem</option>
                    <option value="Toilet & Drainage Problem">Toilet & Drainage Problem</option>
                    <option value="Non ownership animals">Non ownership animals</option>
                    <option value="other">Other</option>
                </select>

            </div>
            <div class="input-group" style="display: none;" id="complaintInput">
                <label for="complainText">Other</label>
                <input type="text" name="complainText" id="complainText" />
            </div>
            <div class="input-group">
                <label for="complainFile">Or select the complaint</label>
                <input type="file" name="image" id="complainFile" />
            </div>
            <div class="btns-group">
                <a href="#" class="btn btn-prev">Previous</a>
                <a href="#" class="btn btn-next">Next</a>
            </div>
        </div>
        <div class="form-step">
            <div class="input-group">
                <label>Responsible Branch</label>

                <select name="responsible">
                    <option selected>...</option>
                    <option value="Tax & Revenue Section">Tax & Revenue Section</option>
                    <option value="Work Section">Work Section</option>
                    <option value="Administration Section">Administration Section</option>
                    <option value="Health Section">Health Section</option>
                    <option value="RI branch">RI branch</option>
                    <option value="General">General</option>
                </select>

            </div>
            <div class="btns-group">
                <a href="#" class="btn btn-prev">Previous</a>
                <button class="btn" type="submit" name="submit">Submit</button>
            </div>
        </div>
    </form>

    <script>
        const prevBtns = document.querySelectorAll(".btn-prev");
        const nextBtns = document.querySelectorAll(".btn-next");
        const progress = document.getElementById("progress");
        const formSteps = document.querySelectorAll(".form-step");
        const progressSteps = document.querySelectorAll(".progress-step");

        let formStepsNum = 0;

        nextBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                formStepsNum++;
                updateFormSteps();
                updateProgressbar();
            });
        });

        prevBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                formStepsNum--;
                updateFormSteps();
                updateProgressbar();
            });
        });

        function updateFormSteps() {
            formSteps.forEach((formStep) => {
                formStep.classList.contains("form-step-active") &&
                    formStep.classList.remove("form-step-active");
            });

            formSteps[formStepsNum].classList.add("form-step-active");
        }

        function updateProgressbar() {
            progressSteps.forEach((progressStep, idx) => {
                if (idx < formStepsNum + 1) {
                    progressStep.classList.add("progress-step-active");
                } else {
                    progressStep.classList.remove("progress-step-active");
                }
            });

            const progressActive = document.querySelectorAll(".progress-step-active");

            progress.style.width =
                ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
        }

        function showInputField() {
            var selectElement = document.getElementById("complaintType");
            var complaintInput = document.getElementById("complaintInput");

            if (selectElement.value.toLowerCase() === 'other') {
                complaintInput.style.display = 'block';
            } else {
                complaintInput.style.display = 'none';
            }
        }
    </script>



</body>

</html>