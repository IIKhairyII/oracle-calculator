<?php
session_start();
include_once "oracle.php";
$sessionId = $_SESSION['sessionId'];
$var = "SELECT * FROM CALCULATIONS WHERE SESSION_ID = '$sessionId' AND OPERATOR <> '0' ORDER BY ID ASC";
$parseVar = oci_parse($orConn, $var);
oci_execute($parseVar);
$array = array();
while ($row = oci_fetch_assoc($parseVar)){
    $array[] = $row;
}
echo json_encode($array);
?>