<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'super_admin') {
    header("Location: index.php");
    exit();
}

?>

<?php

include "./inc/db.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMPLAINT MANAGEMENT | superadmins</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="shortcut icon" href="./img/uvalogo.png" type="image/png">

</head>

<body>

    <nav class="navbar bg-dark">
        <div class="container-fluid">
            <a href="" style="text-decoration: none;"><span class="navbar-brand mb-0 h1 text-light">COMPLAINT MANAGEMENT | superadmins</span></a>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">LOGOUT</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">

        <div role="alert" id="errorMsg" class="text-center">


        </div>

        <a href="export.php"><button class="btn btn-primary mb-3">Export Records</button></a>


        <div class="modal fade" id="updatemodal" tabindex="-1" aria-labelledby="updatemodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updatemodalLabel">Action Taken</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form id="myForm">

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Complaint No.</label>
                                    <input type="text" class="form-control" name="no" id="updateCompNo" disabled>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Complained Date</label>
                                    <input type="text" class="form-control" name="date" id="updateDate" disabled>
                                </div>
                            </div>

                            <div class="my-2">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" id="updateAddress" disabled>
                            </div>

                            <div class="row my-2">
                                <div class="col-md-6">
                                    <label class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control" name="mobNum" id="updatemobNum" disabled>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Whatsapp Number</label>
                                    <input type="text" class="form-control" name="whatNum" id="updatewhatNum" disabled>
                                </div>
                            </div>

                            <div class="row my-2">
                                <div class="col-md-4">
                                    <label class="form-label">Complain</label>
                                    <input type="text" class="form-control" name="complain" id="updateComplain" disabled>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">If other</label>
                                    <input type="text" class="form-control" name="complainOther" id="updateComplainOther" disabled>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Responsible Branch</label>
                                    <input type="text" class="form-control" name="responsible" id="updateRes" disabled>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Field Visit</label>
                                    <input type="text" class="form-control" name="field" id="updateFieldVisit">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Approval</label>
                                    <input type="text" class="form-control text-success" name="field" id="updateApproval">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Actioned Date</label>
                                    <input type="date" class="form-control" name="requirement" id="updateDate">
                                </div>
                            </div>

                            <div class="row my-2">
                                <div class="col-md-6">
                                    <label class="form-label">Pending Requirements</label>
                                    <input type="text" class="form-control" name="requirement" id="updateRequirement">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Remarks</label>
                                    <input type="text" class="form-control text-primary" name="remark" id="updateRemark">
                                </div>
                            </div>


                    </div>

                    </form>
                    <div class="modal-footer">

                        <button type="submit" id="updateData" class="btn btn-dark" style="background-color: #780002 !important;" onclick="updateDetails()">Update</button>
                        <input type="text" id="hiddenid">
                    </div>
                </div>

            </div>
        </div>



        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Pending Complains</button>
                <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Completed Complains</button>
            </div>
        </nav>

        <div class="tab-content my-3" id="nav-tabContent">

            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">

                <table class="table table-bordered table-hover table-striped my-3" id="myDataTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Complained Date</th>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Mobile / Whatsapp No.</th>
                            <th scope="col">Complain</th>
                            <th scope="col">Responsible Branch</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        $sql = "SELECT * FROM informations WHERE status = 'Pending'";

                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row['id'];
                                $complained_date = $row['complained_date'];
                                $name = $row['name'];
                                $address = $row['address'];
                                $number = $row['mobile_num'];
                                $whatNumber = $row['whatsapp_num'];
                                $complain = $row['complain'];
                                $branch = $row['res_branch'];
                                $status = $row['status'];
                                $image = $row['complaintImage'];

                                $imagePath = "uploads/";

                                echo '<tr>
                                        <th>' . $id . '</th>
                                        <td>' . $complained_date . '</td>
                                        <td>' . $name . '</td>
                                        <td>' . $address . '</td>
                                        <td>' . $number . ' / ' . $whatNumber . '</td>
                                        <td>' . $complain . '</td>
                                        <td>' . $branch . '</td>
                                        <td class="text-danger fw-bolder">' . $status . '</td>
                                        <td>
                                            <button class="btn" style="background: none; border: none;" onclick="GetDetails(' . $id . ')"><i class="fa-solid fa-pen-to-square text-primary"></i></button>';

                                            if ($image === "") {
                                                
                                            } else {

                                                echo "<a href='view_image.php?filename=" . $image . "' target='_blank'><button class='btn' style='background: none; border: none;'><i class='fa-solid fa-image text-dark'></i></a></button>";

                                            }

                                echo  '</td>
                                    </tr>';
                            };
                        }

                        ?>
                    </tbody>
                </table>


            </div>

            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">

                <table class="table table-bordered table-hover table-striped my-3" id="newDataTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Name</th>
                            <th scope="col">Mobile / Whatsapp No.</th>
                            <th scope="col">Complain</th>
                            <th scope="col">Field Visit</th>
                            <th scope="col">Approval</th>
                            <th scope="col">Pending Requirements</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $sql = "SELECT * FROM informations WHERE status = 'Done'";

                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row['id'];
                                $filed = $row['field_visit'];
                                $name = $row['name'];
                                $address = $row['address'];
                                $number = $row['mobile_num'];
                                $whatNumber = $row['whatsapp_num'];
                                $complain = $row['complain'];
                                $approval = $row['approval'];
                                $pending = $row['pending_req'];
                                $remarks = $row['remarks'];
                                $status = $row['status'];

                                if ($remarks === "") {
                                    $remarks = "No Special Remarks";
                                }

                                echo '<tr>
                <th>' . $id . '</th>
                <td>' . $name . '</td>
                <td>' . $number . ' / ' . $whatNumber . '</td>
                <td>' . $complain . '</td>
                <td>' . $filed . '</td>
                <td class="text-primary-emphasis fw-semibold">' . $approval . '</td>
                <td>' . $pending . '</td>
                <td class="text-primary">' . $remarks . '</td>
                <td class="text-success fw-bolder">' . $status . '</td>
                
            </tr>';
                            };
                        }

                        ?>
                    </tbody>
                </table>


            </div>

        </div>



    </div>

    <footer>
        <!-- Copyright -->
        <div class="text-center text-dark">
            <p class="text-dark">© <?php echo date("Y"); ?> Dev Kings v4.4</p>
        </div>
        <!-- Copyright -->
    </footer>




    <script>
        $(document).ready(function() {
            $('#myDataTable').DataTable();
        });

        $(document).ready(function() {
            $('#newDataTable').DataTable();
        });


        function GetDetails(updateid) {
            $("#hiddenid").val(updateid);

            $.post("update.php", {
                updateid: updateid
            }, function(data, status) {
                var userid = JSON.parse(data)
                $('#updateCompNo').val(userid.id);
                $('#updateDate').val(userid.complained_date);
                $('#updateAddress').val(userid.address);
                $('#updatemobNum').val(userid.mobile_num);
                $('#updatewhatNum').val(userid.whatsapp_num);
                $('#updateComplain').val(userid.complain);
                $('#updateRes').val(userid.res_branch);
                $('#updateComplainOther').val(userid.complaintText);
            });

            $("#updatemodal").modal("show");
        };

        function updateDetails() {
            var updateFieldVisit = $("#updateFieldVisit").val();
            var updateDate = $("#updateDate").val();
            var updateRequirement = $("#updateRequirement").val();
            var updateRemark = $("#updateRemark").val();
            var updateApproval = $("#updateApproval").val();
            var hiddendata = $("#hiddenid").val();

            $.post("update.php", {
                updateFieldVisit: updateFieldVisit,
                updateDate: updateDate,
                updateRequirement: updateRequirement,
                updateRemark: updateRemark,
                updateApproval: updateApproval,
                hiddendata: hiddendata
            }, function(data, status) {

                $('#myDataTable').DataTable().row($('#hiddenid').closest('tr')).remove().draw(false);
                $("#updatemodal").modal("hide");

                var sucMsg = '<span class="alert alert-success ml-5">Your Actions Updated Successfully</span>';
                $('#errorMsg').html(sucMsg).fadeOut(5000);

                location.reload(false);

            })
        };

        function viewImage(imagePath, imageName) {
            // Open a new window or modal to display the image
            var imageWindow = window.open("", "_blank");
            imageWindow.document.write("<img src='" + imagePath + "' alt='Complaint Image'>");
        }
    </script>

</body>

</html>