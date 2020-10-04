<?php
session_start();
//FILEID ==> seq name
include_once "oracle.php";
$Name = file_get_contents("php://input");
$userInput = json_decode($Name);
$selectNames = "SELECT COUNT(*) FROM FILENAMES WHERE TITLE = '$userInput'";
$parseSelection = oci_parse($orConn, $selectNames);
oci_execute($parseSelection);
$fetchRows = oci_fetch_assoc($parseSelection);
if($fetchRows['COUNT(*)'] > 0){
    echo "This name already exists!! Try another one!!";
}else{
    $sessionId = $_SESSION['sessionId'];
    $userName = $_SESSION['Name'];
    $insertName = "UPDATE calculations SET FILENAME = '$userInput' WHERE SESSION_ID = '$sessionId'";
    $parseName = oci_parse($orConn, $insertName);
    oci_execute($parseName);
    $_SESSION['sessionId'] = md5(rand(0,1000));
    $_SESSION['fileName'] = 'Untitled';
    $fileName = $_SESSION['fileName'];
    $newSession = $_SESSION['sessionId'];
    $insertNewSession = "INSERT INTO CALCULATIONS(SESSION_ID, ID, VALUE, OPERATOR, RESULT, NAME, FILENAME) VALUES('$newSession',NUM_ID.nextval ,'0','0','0', '$userName', '$fileName')";
    $parseSession = oci_parse($orConn, $insertNewSession);
    oci_execute($parseSession);
    $FileName = "INSERT INTO FILENAMES(ID, TITLE) VALUES (FILEID.nextval, '$userInput')";
    $parseFileName = oci_parse($orConn, $FileName);
    oci_execute($parseFileName);
}

?>