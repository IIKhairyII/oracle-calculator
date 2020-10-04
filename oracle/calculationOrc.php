<?php
session_start();
include_once "oracle.php";
$inputs = file_get_contents("php://input");
$phpInput = json_decode($inputs);
$operator = substr($phpInput[0], -1);
$userInput = rtrim($phpInput[0], $operator);
$sessionId = $_SESSION['sessionId'];
$userName = $_SESSION['Name'];
$fileName = $_SESSION['fileName'];
$selectNumberId = "SELECT MAX(id) FROM calculations WHERE SESSION_ID = '$sessionId'";
$parseNum = oci_parse($orConn, $selectNumberId);
oci_execute($parseNum);
$numId = oci_fetch_assoc($parseNum);
$v = $numId['MAX(ID)'];
$selectValue = "SELECT RESULT FROM calculations WHERE ID = '$v'";
$parseValue = oci_parse($orConn, $selectValue);
oci_execute($parseValue);
$value = oci_fetch_assoc($parseValue);
$selectedValue = $value['RESULT'];
$operatorCheck = array("+", "-");
if (in_array($operator, $operatorCheck)){
        if($operator == "+"){
            $result = $selectedValue + $userInput; 
           
        }else{
            $result = $selectedValue - $userInput;
    
        }
        
}else{
    return '';
}
$insertSql = "INSERT INTO calculations(SESSION_ID, ID, VALUE, OPERATOR, RESULT, NAME, FILENAME) VALUES ('$sessionId', NUM_ID.nextval, '$userInput', '$operator', '$result', '$userName', '$fileName')";
$parseInsert = oci_parse($orConn, $insertSql);
oci_execute($parseInsert);
$historySelect = "SELECT * FROM calculations WHERE  SESSION_ID = '$sessionId' AND OPERATOR <> '0' ORDER BY ID ASC";
$parseHistory = oci_parse($orConn, $historySelect);
oci_execute($parseHistory);
$history = array();
while($fetchHistory = oci_fetch_assoc($parseHistory)){
    $history[] = $fetchHistory;
}
$data= array("submission"=> $result);
$encode = array();
$encode = array ($history, $data);
echo json_encode($encode);
?>