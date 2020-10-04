<?php
session_start();
include_once "oracle.php";
$OpenReq = file_get_contents("php://input");
$fileName = json_decode($OpenReq);
$selectOpened = "SELECT * FROM CALCULATIONS WHERE FILENAME = '$fileName'";
$parseOpen = oci_parse($orConn, $selectOpened);
oci_execute($parseOpen);
$fetchOpened = oci_fetch_assoc($parseOpen);
$_SESSION['sessionId'] = $fetchOpened['SESSION_ID'];
$_SESSION['fileName'] = $fileName;
$showArray = array();
while($fetchRows = oci_fetch_assoc($parseOpen)){
    $showArray[] = $fetchRows;
}
echo json_encode($showArray);
?>