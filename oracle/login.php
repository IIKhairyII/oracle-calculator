<?php
session_start();
include_once "oracle.php";
$inputs = file_get_contents("php://input");
$logData = json_decode($inputs, true);
$userName = $logData['userName'];
$password = $logData['password'];
$countRows = "SELECT COUNT(*) FROM CALC_USERS WHERE USERNAME = '$userName'";
$parseCount = oci_parse($orConn, $countRows);
oci_execute($parseCount);
$userCheck= oci_fetch_assoc($parseCount);
if($userCheck['COUNT(*)'] == 0){
    echo "This user doesn't exist!! Sign up NOW!!";
}else{
    $selectUser = "SELECT * FROM CALC_USERS WHERE USERNAME = '$userName'";
    $parseUser = oci_parse($orConn, $selectUser);
    oci_execute($parseUser);
    $fetchUser = oci_fetch_assoc($parseUser);
    if (password_verify($password, $fetchUser['PASSWORD'])){
        $sessionId = md5(rand(0,1000));
        $_SESSION['sessionId'] = $sessionId;
        $idSession = $_SESSION['sessionId'];
        $_SESSION['Name'] = $fetchUser['NAME'];
        $userName = $_SESSION['Name'];
        $_SESSION['fileName'] = 'Untitled';
        $fileName = $_SESSION['fileName'];
        $_SESSION['userName'] = $fetchUser['USERNAME'];
        echo "Success";
        $insertSession = "INSERT INTO CALCULATIONS(SESSION_ID, ID, VALUE, OPERATOR, RESULT, NAME, FILENAME) VALUES('$idSession',NUM_ID.nextval ,'0','0','0', '$userName', '$fileName')";
        $parseSession = oci_parse($orConn, $insertSession);
        oci_execute($parseSession);
    }else {
        echo "Password is incorrect!! Try again";
    }
}


?>