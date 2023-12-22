<?php

include "./inc/db.php";

if (isset($_POST['updateid'])) {
    $user_id = $_POST['updateid'];

    $sql = "SELECT * FROM informations WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $response = array();
    while($row=mysqli_fetch_assoc($result)){
        $response = $row;
    }
    echo json_encode($response);
} else{
    $response['status'] = 200;
    $response['message'] = "Invalid or data not found";
}

if (isset($_POST['hiddendata'])) {
    $uniqueid = $_POST['hiddendata'];
    $field = $_POST['updateFieldVisit'];
    $date = $_POST['updateDate'];
    $requirement = $_POST['updateRequirement'];
    $approval = $_POST['updateApproval'];
    $remark = $_POST['updateRemark'];

    $sqll = "UPDATE informations SET field_visit = '$field', pending_req = '$requirement', approval = '$approval', actioned_date = '$date', remarks = '$remark', status = 'Done' WHERE id = '$uniqueid'";
    $result = mysqli_query($conn, $sqll);
}

?>