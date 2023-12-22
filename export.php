<?php

include_once './inc/db.php';

require_once './inc/PhpXlsxGenerator.php';

$filename = "ComplainRecords . " . date('Y-m-d') . ".xlsx";

$exceldata[] = array('ID', 'COMPLAINED DATE', 'NAME', 'ADDRESS', 'MOBILE NUMBER', 'WHATSAPP NUMBER', 'COMPLAIN', 'RESPONSIBILITY', 'APPROVAL', 'ACTIONED DATE', 'REMARKS', 'STATUS');


$query = $conn->query("SELECT * FROM informations");

if($query->num_rows > 0){
    while($row = $query->fetch_assoc()){

        if ($row['remarks'] === "") {
            $row['remarks'] = "No Special Remarks";
        }

        $linedata = array($row['id'], $row['complained_date'], $row['name'], $row['address'], $row['mobile_num'], $row['whatsapp_num'], $row['complain'], $row['res_branch'], $row['approval'], $row['actioned_date'], $row['remarks'], $row['status']);
        $exceldata[] = $linedata;
    }
}

$xlsx = CodexWorld\PhpXlsxGenerator::fromArray($exceldata);
$xlsx->downloadAs($filename);
exit();


?>