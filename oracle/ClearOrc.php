<?php
session_start();
include_once "oracle.php";
$DeleteInput = file_get_contents("php://input");
$DeleteCheck = json_decode($DeleteInput);
if($DeleteCheck == 1){
    $_SESSION['sessionId'] = md5(rand(0,1000));
    $idSession = $_SESSION['sessionId'];
    $userName = $_SESSION['Name'];
    $_SESSION['fileName'] = 'Untitled';
    $fileName = $_SESSION['fileName'];
    $insertSession = "INSERT INTO CALCULATIONS(SESSION_ID, ID, VALUE, OPERATOR, RESULT, NAME, FILENAME) VALUES('$idSession',NUM_ID.nextval ,'0','0','0', '$userName', '$fileName')";
    $parseSession = oci_parse($orConn, $insertSession);
    oci_execute($parseSession);
    }
$Del = array("confirm" =>$DeleteCheck);
echo json_encode($Del);


?>