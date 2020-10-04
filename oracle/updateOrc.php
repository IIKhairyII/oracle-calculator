<?php
session_start();
include_once "oracle.php";
$sessionId = $_SESSION['sessionId'];
$newValues = file_get_contents("php://input");
$updateValues = json_decode($newValues, true);
$newNum = $updateValues["newNumber"];
$newOp = $updateValues["newOperator"];
$id = $updateValues["id"];
if ($newNum == null || $newOp == null){
    
    echo "No thing is changed";
}else{
    $update = "UPDATE calculations SET VALUE = '$newNum', OPERATOR = '$newOp' WHERE ID = '$id' ";
    $parseUpdate = oci_parse($orConn, $update);
    oci_execute($parseUpdate);
    $selectToUpdate = "SELECT * FROM calculations WHERE SESSION_ID = '$sessionId' AND ID >= '$id'-1";
    $parseUpdate = oci_parse($orConn, $selectToUpdate);
    oci_execute($parseUpdate);
    /*$fetchArray = oci_fetch_assoc($parseUpdate);
    print_r($test);
    echo "<br>";*/
    $data = array();
    while($fetchArray = oci_fetch_assoc($parseUpdate)){
        $data[] = $fetchArray;
}
//echo json_encode($data);
for($a =0 ; $a < count($data)-1; $a++){
    $id = $data[$a]['ID'];
    $selectPrev = "SELECT RESULT FROM calculations WHERE SESSION_ID = '$sessionId' AND ID = '$id'";
    $parsePrev = oci_parse($orConn, $selectPrev);
    oci_execute($parsePrev);
    $prevRes = oci_fetch_assoc($parsePrev);
    if($data[$a+1]['OPERATOR'] == "+"){
        $updatedResult = $prevRes['RESULT'] + $data[$a+1]['VALUE'];
        $currentId = $data[$a+1]['ID'];
        $updateRes = "UPDATE calculations SET RESULT = '$updatedResult' WHERE SESSION_ID = '$sessionId' AND  ID = '$currentId'";
        $parseUpdatedResult = oci_parse($orConn, $updateRes);
        oci_execute($parseUpdatedResult);
        
    }else{
        $updatedResult = $prevRes['RESULT'] - $data[$a+1]['VALUE'];
        $currentId = $data[$a+1]['ID'];
        $updateRes = "UPDATE calculations SET RESULT = '$updatedResult'  WHERE SESSION_ID = '$sessionId' AND  ID = '$currentId'";
        $parseUpdatedResult = oci_parse($orConn, $updateRes);
        oci_execute($parseUpdatedResult);
    }
} 
    $selectUpdated ="SELECT * FROM CALCULATIONS WHERE SESSION_ID = '$sessionId' AND OPERATOR <> '0' ORDER BY ID ASC";
    $parseUpdated = oci_parse($orConn, $selectUpdated);
    oci_execute($parseUpdated);
    $update = array();
    while($fetchAssoc = oci_fetch_assoc($parseUpdated)){
        $update[] = $fetchAssoc;
    }
    echo json_encode($update);
}
?>
