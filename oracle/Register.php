<?php
session_start();
include_once "oracle.php";
$inputs = file_get_contents("php://input");
$data = json_decode($inputs, true);
$_SESSION['name'] = $data['name'];
$_SESSION['userName'] = $data['userName'];
$_SESSION['password'] = $data['pass'];
$name = $data['name'];
$userName = $data['userName'];
$password = password_hash($data['pass'], PASSWORD_BCRYPT);
$countRows = "SELECT COUNT(*) FROM CALC_USERS WHERE USERNAME = '$userName'";
$parseCount = oci_parse($orConn, $countRows);
oci_execute($parseCount);
$assoc= oci_fetch_assoc($parseCount);
if($assoc['COUNT(*)'] > 0 ){
    echo "This username already exists! Try another one!!";
}else{
    $insertData = "INSERT INTO CALC_USERS(ID, NAME, USERNAME, PASSWORD) VALUES(seq.nextval, '$name', '$userName', '$password')";
    $parseData = oci_parse($orConn, $insertData);
    oci_execute($parseData);
   // header("Location: http://localhost/calculator/login.html");
}
/*$selectData = oci_parse($orConn, "SELECT * FROM CALC_USERS");
$executeSelection = oci_execute($selectData);*/


?>